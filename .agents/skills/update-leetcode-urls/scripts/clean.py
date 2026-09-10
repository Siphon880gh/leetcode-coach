#!/usr/bin/env python3
"""Parse context-leetcode-urls/data-input.html into URL and difficulty maps."""

from __future__ import annotations

import json
import re
import sys
from pathlib import Path

ROW_RE = re.compile(
    r'<a href="(/problems/[^"?#]+)[^"]*"[\s\S]*?line-clamp-1">(\d+)\.\s*',
    re.IGNORECASE,
)

DIFF_RE = re.compile(
    r'line-clamp-1">(\d+)\.\s[\s\S]{0,1500}?text-sd-(easy|medium|hard)',
    re.IGNORECASE,
)

DIFF_LABEL = {
    "easy": "Easy",
    "medium": "Med",
    "hard": "Hard",
}


def repo_root() -> Path:
    here = Path(__file__).resolve()
    for parent in here.parents:
        if (parent / "context-leetcode-urls").is_dir() and (parent / "includes" / "content.php").is_file():
            return parent
    return Path.cwd()


def main() -> int:
    root = repo_root()
    src = root / "context-leetcode-urls" / "data-input.html"
    dest = root / "context-leetcode-urls" / "data-cleaned.json"
    dest_diff = root / "context-leetcode-urls" / "data-difficulty.json"

    if not src.is_file():
        print(f"missing {src}", file=sys.stderr)
        return 1

    html = src.read_text(encoding="utf-8")
    rows = ROW_RE.findall(html)
    if not rows:
        print("no problem rows found in data-input.html", file=sys.stderr)
        return 1

    mapping: dict[int, str] = {}
    conflicts: list[str] = []
    for href, num_s in rows:
        n = int(num_s)
        url = "https://leetcode.com" + href
        if n in mapping and mapping[n] != url:
            conflicts.append(f"{n}: {mapping[n]} vs {url}")
            continue
        mapping[n] = url

    if conflicts:
        print("conflicting URLs for the same problem number:", file=sys.stderr)
        for line in conflicts[:20]:
            print(f"  {line}", file=sys.stderr)
        return 1

    diffs: dict[int, str] = {}
    diff_conflicts: list[str] = []
    for num_s, raw in DIFF_RE.findall(html):
        n = int(num_s)
        label = DIFF_LABEL.get(raw.lower())
        if label is None:
            continue
        if n in diffs and diffs[n] != label:
            diff_conflicts.append(f"{n}: {diffs[n]} vs {label}")
            continue
        diffs[n] = label

    if not diffs:
        print("no difficulty labels found in data-input.html", file=sys.stderr)
        return 1

    if diff_conflicts:
        print("conflicting difficulty for the same problem number:", file=sys.stderr)
        for line in diff_conflicts[:20]:
            print(f"  {line}", file=sys.stderr)
        return 1

    ordered = {str(k): mapping[k] for k in sorted(mapping)}
    dest.write_text(json.dumps(ordered, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")

    ordered_diff = {str(k): diffs[k] for k in sorted(diffs)}
    dest_diff.write_text(json.dumps(ordered_diff, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")

    print(f"wrote {dest}")
    print(f"count {len(ordered)}")
    print(f"min {min(mapping)}")
    print(f"max {max(mapping)}")
    print(f"1 {ordered.get('1', '(missing)')}")
    print(f"wrote {dest_diff}")
    print(f"difficulty {len(ordered_diff)}")
    print(f"1 {ordered_diff.get('1', '(missing)')}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

#!/usr/bin/env python3
"""Parse context-leetcode-urls/data-input.html into data-cleaned.json."""

from __future__ import annotations

import json
import re
import sys
from pathlib import Path

ROW_RE = re.compile(
    r'<a href="(/problems/[^"?#]+)[^"]*"[\s\S]*?line-clamp-1">(\d+)\.\s*',
    re.IGNORECASE,
)


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

    ordered = {str(k): mapping[k] for k in sorted(mapping)}
    dest.write_text(json.dumps(ordered, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")

    print(f"wrote {dest}")
    print(f"count {len(ordered)}")
    print(f"min {min(mapping)}")
    print(f"max {max(mapping)}")
    print(f"1 {ordered.get('1', '(missing)')}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

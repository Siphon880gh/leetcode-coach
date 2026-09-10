#!/usr/bin/env python3
"""List scraped LeetCode companies by Filter salary status."""

from __future__ import annotations

import json
import sys
from pathlib import Path

SKILLS = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(SKILLS / "update-leetcode-companies" / "scripts"))

import save  # noqa: E402

OTHER_BUCKETS = {
    "6-Unpriceable": "unpriceable",
    "7-Cooldown": "cooldown",
    "8-WillPrice": "willPrice",
}


def load_levels_companies(dstdir: Path) -> dict[str, dict]:
    path = dstdir / "levels.json"
    if not path.is_file():
        return {}
    data = json.loads(path.read_text(encoding="utf-8"))
    out: dict[str, dict] = {}
    for row in data.get("companies") or []:
        if not isinstance(row, dict):
            continue
        slug = str(row.get("slug") or "").strip().lower()
        if save.SLUG_RE.match(slug):
            out[slug] = row
    return out


def problem_count(data: dict) -> int:
    try:
        return len(save.normalize_problems(data.get("problems") or []))
    except ValueError:
        return 0


def company_item(slug: str, name: str, rel: str, count: int, extra: dict | None = None) -> dict:
    item = {
        "slug": slug,
        "name": name,
        "file": rel,
        "problemCount": count,
    }
    if extra:
        item.update(extra)
    return item


def salary_ok(row: dict | None) -> bool:
    if not row:
        return False
    usd = row.get("seniorTcUsd")
    if not isinstance(usd, int) or usd < 1:
        return False
    level = str(row.get("level") or "").strip()
    return level in save.PRICED_LEVEL_IDS


def find_gaps(root: Path | None = None) -> dict:
    dstdir = save.data_dir(root or save.repo_root())
    levels = load_levels_companies(dstdir)
    missing: list[dict] = []
    will_price: list[dict] = []
    cooldown: list[dict] = []
    unpriceable: list[dict] = []
    ok = 0

    for path in save.iter_company_files(dstdir):
        data = json.loads(path.read_text(encoding="utf-8"))
        if not isinstance(data, dict):
            continue
        slug = str(data.get("slug") or path.stem).strip().lower()
        if not save.SLUG_RE.match(slug):
            continue
        count = problem_count(data)
        if count < 1:
            continue
        name = str(data.get("name") or slug).strip() or slug
        rel = path.relative_to(dstdir).as_posix()
        row = levels.get(slug)
        if row is None:
            missing.append(company_item(slug, name, rel, count, {"reason": "not-in-levels"}))
            continue
        if salary_ok(row):
            ok += 1
            continue
        level = str(row.get("level") or "").strip()
        extra = {"reason": "missing-salary", "level": level}
        note = str(row.get("note") or "").strip()
        if note:
            extra["note"] = note
        item = company_item(slug, name, rel, count, extra)
        bucket = OTHER_BUCKETS.get(level)
        if bucket == "willPrice":
            will_price.append(item)
        elif bucket == "cooldown":
            cooldown.append(item)
        elif bucket == "unpriceable":
            unpriceable.append(item)
        else:
            missing.append(item)

    return {
        "ok": ok,
        "willPrice": will_price,
        "cooldown": cooldown,
        "unpriceable": unpriceable,
        "missing": missing,
    }


def main() -> int:
    payload = find_gaps()
    print(json.dumps(payload, indent=2, ensure_ascii=False))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

#!/usr/bin/env python3
"""Merge scraped LeetCode company problem numbers into context-leetcode-companies/."""

from __future__ import annotations

import json
import re
import sys
from datetime import datetime, timezone
from pathlib import Path
from urllib.parse import parse_qs, urlparse

SLUG_RE = re.compile(r"^[a-z0-9][a-z0-9-]*$")
LEVEL_DIR_RE = re.compile(r"^[1-8]-[A-Za-z]+$")
PRICED_LEVEL_IDS = ("1-Highest", "2-High", "3-Mid", "4-Lower", "5-Lowest")
OTHER_LEVEL_IDS = ("6-Unpriceable", "7-Cooldown", "8-WillPrice")
META_JSON = {"index.json", "levels.json"}


def repo_root() -> Path:
    here = Path(__file__).resolve()
    for parent in here.parents:
        if (parent / "includes" / "content.php").is_file() and (parent / ".agents" / "skills").is_dir():
            return parent
    return Path.cwd()


def data_dir(root: Path) -> Path:
    path = root / "context-leetcode-companies"
    path.mkdir(parents=True, exist_ok=True)
    return path


def load_levels_map(dstdir: Path) -> dict[str, str]:
    path = dstdir / "levels.json"
    if not path.is_file():
        return {}
    data = json.loads(path.read_text(encoding="utf-8"))
    out: dict[str, str] = {}
    for row in data.get("companies") or []:
        slug = str(row.get("slug") or "").strip().lower()
        level = str(row.get("level") or "").strip()
        if SLUG_RE.match(slug) and LEVEL_DIR_RE.match(level):
            out[slug] = level
    return out


def find_existing_company_file(dstdir: Path, slug: str) -> Path | None:
    root_hit = dstdir / f"{slug}.json"
    if root_hit.is_file():
        return root_hit
    for path in sorted(dstdir.glob(f"*/{slug}.json")):
        if path.parent.name in META_JSON:
            continue
        if LEVEL_DIR_RE.match(path.parent.name):
            return path
    return None


def dest_for_slug(dstdir: Path, slug: str, levels_map: dict[str, str]) -> Path:
    level = levels_map.get(slug)
    if level:
        folder = dstdir / level
        folder.mkdir(parents=True, exist_ok=True)
        return folder / f"{slug}.json"
    existing = find_existing_company_file(dstdir, slug)
    if existing:
        return existing
    return dstdir / f"{slug}.json"


def favorite_slug(url: str) -> str | None:
    qs = parse_qs(urlparse(url).query)
    values = qs.get("favoriteSlug") or []
    return values[0] if values else None


def normalize_problems(raw: object) -> list[int]:
    if not isinstance(raw, list):
        raise ValueError("problems must be a list of positive integers")
    out: list[int] = []
    seen: set[int] = set()
    for item in raw:
        if isinstance(item, bool) or not isinstance(item, int):
            raise ValueError(f"invalid problem number: {item!r}")
        if item < 1:
            raise ValueError(f"invalid problem number: {item!r}")
        if item in seen:
            continue
        seen.add(item)
        out.append(item)
    out.sort()
    return out


def merge_record(existing: dict | None, payload: dict) -> dict:
    slug = str(payload.get("slug", "")).strip().lower()
    if not SLUG_RE.match(slug):
        raise ValueError(f"invalid slug: {slug!r}")

    name = str(payload.get("name") or slug).strip() or slug
    url = str(payload.get("url") or "").strip()
    if not url:
        raise ValueError("url is required")

    incoming = normalize_problems(payload.get("problems"))
    old_nums: list[int] = []
    if existing:
        old_nums = normalize_problems(existing.get("problems") or [])

    problems = sorted(set(old_nums) | set(incoming))
    now = datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")

    return {
        "slug": slug,
        "name": name,
        "url": url,
        "favoriteSlug": favorite_slug(url),
        "updatedAt": now,
        "problems": problems,
    }


def iter_company_files(dstdir: Path) -> list[Path]:
    found: list[Path] = []
    for path in sorted(dstdir.glob("*.json")):
        if path.name in META_JSON:
            continue
        found.append(path)
    for path in sorted(dstdir.glob("*/*.json")):
        if path.name in META_JSON:
            continue
        if not LEVEL_DIR_RE.match(path.parent.name):
            continue
        found.append(path)
    return found


def rebuild_index(dstdir: Path) -> dict:
    levels_map = load_levels_map(dstdir)
    companies: list[dict] = []
    for path in iter_company_files(dstdir):
        data = json.loads(path.read_text(encoding="utf-8"))
        slug = data["slug"]
        rel = path.relative_to(dstdir).as_posix()
        level = levels_map.get(slug)
        if not level and path.parent != dstdir and LEVEL_DIR_RE.match(path.parent.name):
            level = path.parent.name
        entry = {
            "slug": slug,
            "name": data.get("name") or slug,
            "count": len(data.get("problems") or []),
            "file": rel,
        }
        if level:
            entry["level"] = level
        companies.append(entry)
    companies.sort(key=lambda row: row["slug"])
    index = {
        "updatedAt": datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ"),
        "companies": companies,
    }
    (dstdir / "index.json").write_text(
        json.dumps(index, indent=2, ensure_ascii=False) + "\n",
        encoding="utf-8",
    )
    return index


def save_payload(root: Path, payload: dict) -> dict:
    incoming = normalize_problems(payload.get("problems"))
    if not incoming:
        raise ValueError("refusing to write an empty problem list")

    slug = str(payload.get("slug", "")).strip().lower()
    if not SLUG_RE.match(slug):
        raise ValueError(f"invalid slug: {slug!r}")

    dstdir = data_dir(root)
    levels_map = load_levels_map(dstdir)
    dest = dest_for_slug(dstdir, slug, levels_map)
    existing_path = find_existing_company_file(dstdir, slug)
    existing = None
    if existing_path and existing_path.is_file():
        existing = json.loads(existing_path.read_text(encoding="utf-8"))

    record = merge_record(existing, payload)
    dest.parent.mkdir(parents=True, exist_ok=True)
    dest.write_text(json.dumps(record, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")
    if existing_path and existing_path.resolve() != dest.resolve() and existing_path.is_file():
        existing_path.unlink()
    index = rebuild_index(dstdir)
    return {"file": str(dest.relative_to(root)), "record": record, "indexCount": len(index["companies"])}


def self_test() -> None:
    merged = merge_record(
        {"slug": "google", "problems": [1, 5]},
        {
            "slug": "google",
            "name": "Google",
            "url": "https://leetcode.com/company/google/?favoriteSlug=google-thirty-days",
            "problems": [5, 2, 2],
        },
    )
    assert merged["slug"] == "google"
    assert merged["name"] == "Google"
    assert merged["favoriteSlug"] == "google-thirty-days"
    assert merged["problems"] == [1, 2, 5]
    try:
        normalize_problems([-1])
        raise AssertionError("expected invalid problem number")
    except ValueError:
        pass
    try:
        save_payload(Path("/tmp"), {"slug": "google", "url": "https://leetcode.com/company/google/", "problems": []})
        raise AssertionError("expected empty list rejection")
    except ValueError:
        pass
    assert LEVEL_DIR_RE.match("5-Lowest")
    assert LEVEL_DIR_RE.match("8-WillPrice")
    assert LEVEL_DIR_RE.match("6-Unpriceable")
    assert LEVEL_DIR_RE.match("7-Cooldown")
    assert not LEVEL_DIR_RE.match("9-Nope")


def main() -> int:
    if "--self-test" in sys.argv:
        self_test()
        print("ok")
        return 0

    raw = sys.stdin.read()
    if not raw.strip():
        print("expected JSON on stdin", file=sys.stderr)
        return 1
    try:
        payload = json.loads(raw)
    except json.JSONDecodeError as exc:
        print(f"invalid JSON: {exc}", file=sys.stderr)
        return 1
    if not isinstance(payload, dict):
        print("JSON object required", file=sys.stderr)
        return 1

    try:
        result = save_payload(repo_root(), payload)
    except ValueError as exc:
        print(str(exc), file=sys.stderr)
        return 1

    record = result["record"]
    print(f"wrote {result['file']}")
    print(f"slug {record['slug']}")
    print(f"count {len(record['problems'])}")
    print(f"companies {result['indexCount']}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

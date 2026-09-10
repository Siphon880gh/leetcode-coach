#!/usr/bin/env python3
"""Add a scraped company to levels.json (priced band or Others) and rebuild the Filter catalog."""

from __future__ import annotations

import json
import sys
from datetime import datetime, timezone
from pathlib import Path

SKILLS = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(SKILLS / "update-leetcode-companies" / "scripts"))

import save  # noqa: E402

LEVEL_IDS = list(save.PRICED_LEVEL_IDS)
OTHER_LEVEL_IDS = list(save.OTHER_LEVEL_IDS)


def assign_level(usd: int, companies: list[dict], skip_slug: str) -> str:
    floors: dict[str, int] = {}
    max_tc: int | None = None
    for row in companies:
        if not isinstance(row, dict):
            continue
        if str(row.get("slug") or "").strip().lower() == skip_slug:
            continue
        level = str(row.get("level") or "").strip()
        tc = row.get("seniorTcUsd")
        if level not in LEVEL_IDS or not isinstance(tc, int) or tc < 1:
            continue
        floors[level] = tc if level not in floors else min(floors[level], tc)
        max_tc = tc if max_tc is None else max(max_tc, tc)
    if not floors:
        return "1-Highest"
    if max_tc is not None and usd > max_tc:
        return "1-Highest"
    for level in LEVEL_IDS:
        if level in floors and usd >= floors[level]:
            return level
    return "5-Lowest"


def parse_usd(value: object) -> int:
    if isinstance(value, bool) or not isinstance(value, (int, float, str)):
        raise ValueError("seniorTcUsd is required")
    if isinstance(value, float):
        if value != int(value):
            raise ValueError(f"invalid seniorTcUsd: {value!r}")
        amount = int(value)
    elif isinstance(value, int):
        amount = value
    else:
        raw = value.strip().lower().replace(",", "").replace("$", "")
        if raw.endswith("k") and raw[:-1].replace(".", "", 1).isdigit():
            amount = int(round(float(raw[:-1]) * 1000))
        elif raw.isdigit():
            amount = int(raw)
        else:
            raise ValueError(f"invalid seniorTcUsd: {value!r}")
    if amount < 1:
        raise ValueError("seniorTcUsd must be a positive integer")
    return amount


def has_salary(payload: dict) -> bool:
    value = payload.get("seniorTcUsd")
    if value in (None, ""):
        return False
    return True


def require_scraped(dstdir: Path, slug: str) -> dict:
    existing = save.find_existing_company_file(dstdir, slug)
    if existing is None or not existing.is_file():
        raise ValueError(f"no scraped problem list for {slug!r}; run update-leetcode-companies first")
    data = json.loads(existing.read_text(encoding="utf-8"))
    if not isinstance(data, dict):
        raise ValueError(f"invalid company file for {slug!r}")
    if not save.normalize_problems(data.get("problems") or []):
        raise ValueError(f"empty problem list for {slug!r}")
    return data


def move_to_level(dstdir: Path, slug: str, level: str) -> Path:
    dest = dstdir / level / f"{slug}.json"
    dest.parent.mkdir(parents=True, exist_ok=True)
    existing = save.find_existing_company_file(dstdir, slug)
    if existing is None:
        raise ValueError(f"no scraped problem list for {slug!r}")
    if existing.resolve() != dest.resolve():
        dest.write_text(existing.read_text(encoding="utf-8"), encoding="utf-8")
        existing.unlink()
    return dest


def replace_company(companies: list[dict], entry: dict) -> list[dict]:
    slug = entry["slug"]
    next_rows: list[dict] = []
    replaced = False
    for row in companies:
        if str(row.get("slug") or "").strip().lower() == slug:
            next_rows.append(entry)
            replaced = True
        else:
            next_rows.append(row)
    if not replaced:
        next_rows.append(entry)
    next_rows.sort(key=lambda row: (-int(row.get("seniorTcUsd") or 0), str(row.get("name") or "")))
    return next_rows


def upsert_priced(levels: dict, payload: dict, scraped: dict) -> dict:
    slug = str(payload.get("slug") or "").strip().lower()
    usd = parse_usd(payload.get("seniorTcUsd"))
    source = str(payload.get("sourceUrl") or "").strip()
    if not source:
        raise ValueError("sourceUrl is required")
    title = str(payload.get("seniorTitle") or "").strip()
    name = str(payload.get("name") or scraped.get("name") or slug).strip() or slug

    companies = [row for row in (levels.get("companies") or []) if isinstance(row, dict)]
    level = assign_level(usd, companies, slug)
    entry = {
        "slug": slug,
        "name": name,
        "level": level,
        "seniorTcUsd": usd,
        "seniorTitle": title,
        "sourceUrl": source,
    }
    levels["companies"] = replace_company(companies, entry)
    return entry


def upsert_other(levels: dict, payload: dict, scraped: dict) -> dict:
    slug = str(payload.get("slug") or "").strip().lower()
    level = str(payload.get("level") or "").strip()
    if level not in OTHER_LEVEL_IDS:
        raise ValueError(
            "level must be 6-Unpriceable, 7-Cooldown, or 8-WillPrice when seniorTcUsd is omitted"
        )
    name = str(payload.get("name") or scraped.get("name") or slug).strip() or slug
    entry: dict = {
        "slug": slug,
        "name": name,
        "level": level,
    }
    note = str(payload.get("note") or "").strip()
    if note:
        entry["note"] = note
    source = str(payload.get("sourceUrl") or "").strip()
    if source:
        entry["sourceUrl"] = source

    companies = [row for row in (levels.get("companies") or []) if isinstance(row, dict)]
    levels["companies"] = replace_company(companies, entry)
    return entry


def upsert_company(levels: dict, payload: dict, scraped: dict) -> dict:
    slug = str(payload.get("slug") or "").strip().lower()
    if not save.SLUG_RE.match(slug):
        raise ValueError(f"invalid slug: {slug!r}")
    if has_salary(payload):
        return upsert_priced(levels, payload, scraped)
    return upsert_other(levels, payload, scraped)


def apply_payload(root: Path, payload: dict) -> dict:
    slug = str(payload.get("slug") or "").strip().lower()
    dstdir = save.data_dir(root)
    scraped = require_scraped(dstdir, slug)
    levels_path = dstdir / "levels.json"
    if not levels_path.is_file():
        raise ValueError("missing context-leetcode-companies/levels.json")
    levels = json.loads(levels_path.read_text(encoding="utf-8"))
    if not isinstance(levels, dict):
        raise ValueError("invalid levels.json")

    entry = upsert_company(levels, payload, scraped)
    levels["updatedAt"] = datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")
    levels_path.write_text(json.dumps(levels, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")
    dest = move_to_level(dstdir, slug, entry["level"])
    index = save.rebuild_index(dstdir)
    return {
        "file": dest.relative_to(root).as_posix(),
        "entry": entry,
        "indexCount": len(index["companies"]),
    }


def payloads_from_stdin(raw: str) -> list[dict]:
    data = json.loads(raw)
    if isinstance(data, dict) and isinstance(data.get("companies"), list):
        rows = data["companies"]
    elif isinstance(data, list):
        rows = data
    elif isinstance(data, dict):
        rows = [data]
    else:
        raise ValueError("JSON object or list required")
    out: list[dict] = []
    for row in rows:
        if not isinstance(row, dict):
            raise ValueError("each company must be an object")
        out.append(row)
    if not out:
        raise ValueError("no companies in payload")
    return out


def queue_missing_payloads(root: Path) -> list[dict]:
    dstdir = save.data_dir(root)
    levels_path = dstdir / "levels.json"
    known: set[str] = set()
    if levels_path.is_file():
        data = json.loads(levels_path.read_text(encoding="utf-8"))
        for row in data.get("companies") or []:
            if not isinstance(row, dict):
                continue
            slug = str(row.get("slug") or "").strip().lower()
            if save.SLUG_RE.match(slug):
                known.add(slug)
    out: list[dict] = []
    for path in save.iter_company_files(dstdir):
        data = json.loads(path.read_text(encoding="utf-8"))
        if not isinstance(data, dict):
            continue
        slug = str(data.get("slug") or path.stem).strip().lower()
        if not save.SLUG_RE.match(slug) or slug in known:
            continue
        try:
            count = len(save.normalize_problems(data.get("problems") or []))
        except ValueError:
            continue
        if count < 1:
            continue
        name = str(data.get("name") or slug).strip() or slug
        out.append({"slug": slug, "name": name, "level": "8-WillPrice"})
        known.add(slug)
    return out


def print_result(result: dict) -> None:
    entry = result["entry"]
    print(f"wrote {result['file']}")
    print(f"slug {entry['slug']}")
    print(f"level {entry['level']}")
    if "seniorTcUsd" in entry:
        print(f"seniorTcUsd {entry['seniorTcUsd']}")
    if entry.get("note"):
        print(f"note {entry['note']}")
    print(f"companies {result['indexCount']}")


def self_test() -> None:
    sample = [
        {"slug": "a", "level": "1-Highest", "seniorTcUsd": 429000},
        {"slug": "b", "level": "2-High", "seniorTcUsd": 374000},
        {"slug": "c", "level": "5-Lowest", "seniorTcUsd": 80000},
        {"slug": "d", "level": "8-WillPrice"},
    ]
    assert assign_level(500000, sample, "x") == "1-Highest"
    assert assign_level(400000, sample, "x") == "2-High"
    assert assign_level(50000, sample, "x") == "5-Lowest"
    assert assign_level(200000, [], "x") == "1-Highest"
    assert parse_usd(429000) == 429000
    assert parse_usd("$429k") == 429000
    assert parse_usd("429,000") == 429000
    try:
        parse_usd(None)
        raise AssertionError("expected missing salary")
    except ValueError:
        pass
    levels = {"companies": list(sample)}
    other = upsert_other(
        levels,
        {"slug": "x", "name": "X", "level": "7-Cooldown", "note": "blocked"},
        {"name": "X"},
    )
    assert other["level"] == "7-Cooldown"
    assert "seniorTcUsd" not in other
    assert other["note"] == "blocked"
    try:
        upsert_other(levels, {"slug": "y", "level": "1-Highest"}, {"name": "Y"})
        raise AssertionError("expected invalid other level")
    except ValueError:
        pass


def main() -> int:
    if "--self-test" in sys.argv:
        self_test()
        print("ok")
        return 0

    root = save.repo_root()
    queue_missing = "--queue-missing" in sys.argv
    if queue_missing and sys.stdin.isatty():
        raw = ""
    else:
        raw = sys.stdin.read()
    rows: list[dict] = []
    if queue_missing:
        rows.extend(queue_missing_payloads(root))
        if not rows and not raw.strip():
            print("no missing companies to queue")
            return 0
    if raw.strip():
        try:
            rows.extend(payloads_from_stdin(raw))
        except (json.JSONDecodeError, ValueError) as exc:
            print(str(exc), file=sys.stderr)
            return 1
    if not rows:
        print("expected JSON on stdin, or --queue-missing", file=sys.stderr)
        return 1

    for payload in rows:
        try:
            result = apply_payload(root, payload)
        except ValueError as exc:
            print(str(exc), file=sys.stderr)
            return 1
        print_result(result)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

---
name: sync-leetcode-company-filter
description: >-
  Adds scraped LeetCode companies that are missing from the Filter popover,
  including senior engineer salary from Levels.fyi. Use when a company
  problem list exists under context-leetcode-companies/ but is missing from
  Filter → Companies, when a company is in Others (Will Price) or Others
  (Cooldown), after update-leetcode-companies, or when the user asks to sync
  the company filter.
---

# Sync scraped companies into the Filter popover

This skill is **strictly** for scraped company problem lists that are missing from **Filter → Companies**, that sit in an **Others** bucket, or that appear in a pay band **without** senior engineer salary.

Do not scrape LeetCode problem numbers (that is `update-leetcode-companies`). Do not invent salaries. Do not rebuild the Filter UI.

## Bands

Priced (US senior SWE median TC): `1-Highest` … `5-Lowest`.

Three **Others** buckets (no `seniorTcUsd`; they still appear in the popover):

| id | Filter name | When |
|----|-------------|------|
| `8-WillPrice` | Others (Will Price) | Queued for salary lookup (new scrape, not looked up yet) |
| `7-Cooldown` | Others (Cooldown) | Levels.fyi / Comparably blocked or the page would not load **for now** |
| `6-Unpriceable` | Others (Unpriceable) | Looked up; no usable US senior USD source |

A company is **in the popover with salary** only when all of these hold:

1. A problem-list JSON exists under `context-leetcode-companies/` (not `index.json` / `levels.json`) with at least one problem
2. `context-leetcode-companies/levels.json` has that slug with `seniorTcUsd` and a priced band (`1-Highest` … `5-Lowest`)
3. `index.json` lists the file (rebuilt by apply)

A company is **in the popover without salary** when `levels.json` maps it to `6-Unpriceable`, `7-Cooldown`, or `8-WillPrice`.

## 1 — list gaps

From the repo root:

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/gaps.py
```

- `missing` — scraped, not in `levels.json` at all (not in the named Filter groups yet)
- `willPrice` — look these up
- `cooldown` — retry when the salary sites load again
- `unpriceable` — skip unless the user asks to retry
- `ok` — priced count (`1-Highest` … `5-Lowest`)

If `missing` is non-empty, queue those slugs into Will Price so they show in the filter, then look them up:

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/apply.py --queue-missing
```

If `willPrice` and `cooldown` and `missing` are all empty, report `ok` and stop (do not reopen Unpriceable unless asked).

## 2 — look up senior TC (do not invent)

For each `willPrice` company (and `cooldown` when retrying), open Levels.fyi in the browser (reuse one tab):

`https://www.levels.fyi/companies/{levelsSlug}/salaries/software-engineer`

Prefer the **United States** view when a location control exists (`…/locations/united-states` is fine).

**Levels.fyi slug aliases** (LeetCode slug → Levels.fyi path):

| LeetCode slug | Levels.fyi |
|---------------|------------|
| `facebook` | `meta` |
| `tiktok` | `bytedance` |
| `snapchat` | `snap` |
| `walmart-labs` | `walmart` |
| `jpmorgan` | `jpmorgan-chase` |

Otherwise try the LeetCode slug as-is.

Take **median total compensation** for the level labeled **Senior** (or the closest 5–8 year IC band). Record:

- `seniorTcUsd` — integer USD (no `$`, no `k`)
- `seniorTitle` — the level name on that page (e.g. `L5 Senior SWE`)
- `sourceUrl` — the page you used

If Levels.fyi has no US senior SWE median, use Comparably **Senior Software Engineer** for that company (same fallback as TCS in `levels.json`). Do **not** use a company-wide all-roles average as senior.

**If the salary site blocks you or the page will not load:** apply `7-Cooldown` with a short `note`. Do not guess.

**If you loaded a source but it is not usable US senior USD** (wrong country/currency, no Senior SWE title): apply `6-Unpriceable` with a short `note`. Do not convert foreign currency. Do not invent.

**Extract (CDP `Runtime.evaluate`, `returnByValue: true`):**

```javascript
(() => {
  const rows = [];
  for (const tr of document.querySelectorAll("table tr")) {
    const cells = [...tr.querySelectorAll("th,td")].map((c) => (c.textContent || "").trim());
    if (!cells.length) continue;
    const line = cells.join(" | ");
    if (/senior|swe|sde|mts|ict|ic-?\d|e5|l5|l6/i.test(line) && /\$[\d,.]+k?/i.test(line)) {
      rows.push(cells);
    }
  }
  return { title: document.title, url: location.href, rows: rows.slice(0, 24) };
})()
```

Pick the Senior IC row from `rows`. Convert `$429K` / `$429,000` to `429000`.

## 3 — apply

### Priced

After each looked-up company (stdin JSON). `seniorTcUsd` and `sourceUrl` are required. Apply assigns `1-Highest` … `5-Lowest` and moves the company out of Others.

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/apply.py <<'EOF'
{"slug":"netflix","name":"Netflix","seniorTcUsd":450000,"seniorTitle":"L5 Senior Software Engineer","sourceUrl":"https://www.levels.fyi/companies/netflix/salaries/software-engineer"}
EOF
```

### Others (no salary)

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/apply.py <<'EOF'
{"slug":"roku","name":"Roku","level":"7-Cooldown","note":"Levels.fyi US page would not load"}
EOF
```

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/apply.py <<'EOF'
{"slug":"agoda","name":"Agoda","level":"6-Unpriceable","note":"Levels.fyi Thailand THB only; no US senior USD"}
EOF
```

`level` must be `6-Unpriceable`, `7-Cooldown`, or `8-WillPrice`. Optional `note` and `sourceUrl`. Do not send `seniorTcUsd`.

The script:

1. Requires an existing scraped problem list for that slug (run `update-leetcode-companies` first if missing)
2. Writes/updates the company in `levels.json`
3. For salary rows: assigns `1-Highest` … `5-Lowest` from existing **priced** band floors (highest band first; above every company → `1-Highest`; below every company → `5-Lowest`). Others rows are ignored when computing floors.
4. Moves the problem file into `context-leetcode-companies/{level}/{slug}.json`
5. Rebuilds `index.json`

Do not hand-edit `levels.json` when apply can write it. Do not change other companies’ bands.

## 4 — confirm

```bash
php -r 'require "includes/content.php";
foreach (content_leetcode_companies_grouped() as $g) {
  foreach ($g["companies"] as $c) {
    if ($c["slug"] === $argv[1]) {
      echo $g["name"], " ", $c["name"], " ", ($c["seniorTcUsd"] ?? "none"), "\n";
    }
  }
}' -- netflix
```

Report slug, band, `$` compact TC (or Others group), and any skipped companies.

A list of objects (`{"companies":[...]}`) is also accepted by apply.

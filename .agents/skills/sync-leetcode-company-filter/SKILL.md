---
name: sync-leetcode-company-filter
description: >-
  Adds scraped LeetCode companies that are missing from the Filter popover,
  including senior engineer salary from Levels.fyi. Use when a company
  problem list exists under context-leetcode-companies/ but is missing from
  Filter → Companies, when a company is in the filter without senior TC, after
  update-leetcode-companies, or when the user asks to sync the company filter.
---

# Sync scraped companies into the Filter popover

This skill is **strictly** for scraped company problem lists that are missing from **Filter → Companies**, or that appear there **without** senior engineer salary.

Do not scrape LeetCode problem numbers (that is `update-leetcode-companies`). Do not invent salaries. Do not rebuild the Filter UI.

A company is **in the popover with salary** only when all of these hold:

1. A problem-list JSON exists under `context-leetcode-companies/` (not `index.json` / `levels.json`) with at least one problem
2. `context-leetcode-companies/levels.json` has that slug with `seniorTcUsd` and a band (`1-Highest` … `5-Lowest`)
3. `index.json` lists the file (rebuilt by apply)

## 1 — list gaps

From the repo root:

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/gaps.py
```

If `missing` is empty, report that and stop.

## 2 — look up senior TC (do not invent)

For **each** `missing` company, open Levels.fyi in the browser (reuse one tab):

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

If Levels.fyi has no US senior SWE median, use Comparably senior software engineer for that company (same fallback as TCS in `levels.json`). If neither has a number, skip that company and say so — do not guess.

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

## 3 — apply (salary required)

After each looked-up company (stdin JSON). `seniorTcUsd` is required — apply refuses a row without it.

```bash
python3 .agents/skills/sync-leetcode-company-filter/scripts/apply.py <<'EOF'
{"slug":"netflix","name":"Netflix","seniorTcUsd":450000,"seniorTitle":"L5 Senior Software Engineer","sourceUrl":"https://www.levels.fyi/companies/netflix/salaries/software-engineer"}
EOF
```

The script:

1. Requires an existing scraped problem list for that slug (run `update-leetcode-companies` first if missing)
2. Writes/updates the company in `levels.json` with `seniorTcUsd`, `seniorTitle`, `sourceUrl`
3. Assigns `1-Highest` … `5-Lowest` from existing band floors (highest band first; above every company → `1-Highest`; below every company → `5-Lowest`)
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

Report slug, band, `$` compact TC, and any skipped companies.

A list of objects (`{"companies":[...]}`) is also accepted by apply.
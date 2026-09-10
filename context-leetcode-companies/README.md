# LeetCode company filter

Run these Cursor skills **in this order** to refresh company interview lists and the app’s **Filter → Companies** popover.

## 1. `update-leetcode-companies`

Get the latest problem sets per company.

Skill: [`.agents/skills/update-leetcode-companies`](../.agents/skills/update-leetcode-companies/SKILL.md)

Signs into LeetCode, walks each company on the problem set, and saves problem numbers under this folder (`{level}/{slug}.json` or `{slug}.json`, plus `index.json`).

## 2. `sync-leetcode-company-filter`

Render those companies into the app as filters, including salary lookup.

Skill: [`.agents/skills/sync-leetcode-company-filter`](../.agents/skills/sync-leetcode-company-filter/SKILL.md)

Finds scraped companies missing from the Filter popover (or sitting in Others), looks up US senior SWE median total compensation (Levels.fyi; Comparably if needed), writes `levels.json`, and rebuilds `index.json`.

### Filter groups

**Priced** (US senior SWE median TC): Highest, High, Mid, Lower, Lowest.

**Others** (no salary on the chip):

| Folder | Filter name | Meaning |
|--------|-------------|---------|
| `8-WillPrice` | Others (Will Price) | Queued for salary lookup |
| `7-Cooldown` | Others (Cooldown) | Levels.fyi / Comparably blocked or would not load for now |
| `6-Unpriceable` | Others (Unpriceable) | No usable US senior USD source |

After a scrape, queue new slugs into Will Price (`apply.py --queue-missing`), then look them up. Cooldown is for retry later. Unpriceable is done unless you ask to retry.

Do not invent problem numbers or salaries. Do not skip step 1 for a company that has no problem list yet.

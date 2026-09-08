# LeetCode company filter

Run these Cursor skills **in this order** to refresh company interview lists and the app’s **Filter → Companies** popover.

## 1. `update-leetcode-companies`

Get the latest problem sets per company.

Skill: [`.agents/skills/update-leetcode-companies`](../.agents/skills/update-leetcode-companies/SKILL.md)

Signs into LeetCode, walks each company on the problem set, and saves problem numbers under this folder (`{level}/{slug}.json` or `{slug}.json`, plus `index.json`).

## 2. `sync-leetcode-company-filter`

Render those companies into the app as filters, including the salary (which is another research task this skill does).

Skill: [`.agents/skills/sync-leetcode-company-filter`](../.agents/skills/sync-leetcode-company-filter/SKILL.md)

Finds scraped companies missing from the Filter popover (or missing senior TC), looks up US senior SWE median total compensation (Levels.fyi; Comparably if needed), writes `levels.json`, and rebuilds `index.json`.

Do not invent problem numbers or salaries. Do not skip step 1 for a company that has no problem list yet.

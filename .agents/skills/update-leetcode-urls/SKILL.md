---
name: update-leetcode-urls
description: >-
  Use when updating the LeetCode url to LeetCode number map, refreshing
  context-leetcode-urls/data-cleaned.json or data-input.html, copying HTML from
  https://leetcode.com/problemset/, or when LeetCode numbers in the app should
  open the LeetCode coding page in a tab.
---

# Update LeetCode urls to LeetCode numbers

This skill is **strictly** for refreshing the problem-number → `https://leetcode.com/problems/...` map used by this app.

Do not scrape LeetCode. Do not invent URLs. Do not `Read()` `data-input.html` or `data-cleaned.json` whole (the HTML dump is huge).

## Gate 1 — introduce, report, ask, then stop

On start, **before any other work**:

1. Introduce yourself as updating the leetcode url to leetcode number.
2. Report the largest number leetcode number per the data-cleaned.json. Compute it from `context-leetcode-urls/data-cleaned.json` (max integer key). If the file is missing, say so and treat the largest number as unknown.
3. Asks user if they want to update to current leetcode.

**STOP.** Wait for a yes or no. Do not give copy/paste instructions until they say yes.

If they say no, stop.

## Gate 2 — copy HTML, then stop

If they want to update to current leetcode, guide them to copy and paste the HTML at the element that names the table containing all the problems at https://leetcode.com/problemset/ and to save them to `context-leetcode-urls/data-input.html`.

Tell them:

1. Open https://leetcode.com/problemset/ in the browser.
2. Load the full problem list in that table (scroll / page until every problem row you want is in the DOM — a single first page is not enough).
3. In DevTools, select the element that names the table containing all the problems.
4. Copy that element's HTML (Copy → Copy outerHTML).
5. Paste it into `context-leetcode-urls/data-input.html`, replacing the file.
6. Then let me (the AI) know when ready so I can clean the input into a map of leetcode problem to url.

**STOP.** Wait until they say they are ready.

## Gate 3 — clean the map

When they say ready:

1. Confirm `context-leetcode-urls/data-input.html` exists and contains `/problems/` links plus titles like `1. Two Sum`.
2. From the repo root run:

```bash
python3 .agents/skills/update-leetcode-urls/scripts/clean.py
```

3. The script writes `context-leetcode-urls/data-cleaned.json`: problem number → `https://leetcode.com/problems/{slug}` (no query string). Report its count and new largest number.
4. If the script fails or finds fewer than a few hundred problems, do not keep a partial overwrite as done. Inspect a small HTML sample with a script (not `Read()` of the whole file), fix the parser if the markup changed, or ask them to copy the full table again.

Do not invent missing numbers. Duplicate numbers with the same URL are fine; different URLs for the same number is a stop-and-ask.

## Gate 4 — links open the coding page in a tab

Then I (the AI) will make sure leetcode problems link to the leetcode coding page in a tab.

1. App lookup is `content_leetcode_url()` in `includes/content.php`, which reads `context-leetcode-urls/data-cleaned.json`.
2. UI labels go through `content_leetcode_label_html()` / `render_leetcode_row()` and the Browse panel. They must be `<a class="leetcode-link" href="{url}" target="_blank" rel="noopener noreferrer">` (never nested inside another `<a>`).
3. If that wiring is missing, restore it. If only the JSON changed, a PHP lookup check is enough:

```bash
php -r 'require "includes/content.php"; echo content_leetcode_url(1), "\n";'
```

4. Spot-check that a known number (for example 1 → two-sum) still matches the new map.

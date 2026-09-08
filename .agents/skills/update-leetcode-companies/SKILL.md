---
name: update-leetcode-companies
description: >-
  Use when scraping or refreshing LeetCode company interview problem lists,
  company data files under context-leetcode-companies/, Cursor or Claude Code
  browsing of leetcode.com/problemset/ or /company/ pages, or preparing a
  company filter for algorithm interviews.
---

# Update LeetCode company problem lists

This skill is **strictly** for signing into LeetCode in a browser tab, opening the problem set, visiting each company on the right, lazy-loading every problem row, and saving problem numbers into `context-leetcode-companies/`.

Do not invent problem numbers. Do not scrape while signed out. Do not skip scrolling. Do not implement the company filter UI here.

**Browser:** Cursor `cursor-ide-browser` or Claude Code browsing / computer-use. Same gates in both.

## Gate 1 — open a tab, ask to sign in, then stop

On start, **before any scrape**:

1. Introduce yourself as updating LeetCode company problem lists.
2. Open **https://leetcode.com/** in a **new visible tab** so the user can sign in:
   - Cursor: `browser_navigate` with `url: "https://leetcode.com/"`, `newTab: true`, `position: "active"`.
   - Claude Code: open the same URL in a new visible browser tab.
3. Do **not** lock the tab. The user must be able to type credentials (or click **Take Control**).
4. Ask the user to sign in on that tab, then tell you when they are signed in.

**STOP.** Wait for them to say they are signed in. Do not open `/problemset/` or any `/company/` URL yet.

If they say no / cancel, stop.

## Gate 2 — prove signed in

When they say they are signed in:

1. Snapshot the existing LeetCode tab (do not open a fresh anonymous tab).
2. **Signed in** only if **all** hold:
   - URL host is `leetcode.com` and path is **not** `/accounts/login` (and not a login/oauth redirect).
   - Header has a profile / avatar control, or a link to `/u/` or `/profile`, or other account chrome.
   - Header does **not** show a primary **Sign in** / **Create Account** CTA as the logged-out navbar.
3. If not proven: ask them to finish signing in on **that same tab**. **STOP** again.

## Gate 3 — problem set, then each company

Once signed in is proven:

1. Open the **Problem List** / problem set: **https://leetcode.com/problemset/**
2. On the **right**, use the company list (Trending Companies / Companies). Expand **more** / **show more** if it exists so every company control is present.
3. Collect every company from that right-hand list. URLs look like `https://leetcode.com/company/google/?favoriteSlug=google-thirty-days`. Record `slug`, visible `name`, and full `url` (keep `favoriteSlug` as shown).
4. For **each** company:
   1. Click it (or navigate the same tab to that company URL).
   2. Wait until the problem table/list is present.
   3. **Lazy load:** scroll the problem list to the bottom until every row is in the DOM (see **Scroll until loaded**).
   4. Scrape problem **numbers** only (`1`, `2`, `3`, …) from titles like `1. Two Sum`.
   5. Save immediately with `save.py` (below). If `context-leetcode-companies/{slug}.json` already exists, the script **updates** it (union of numbers). Never replace an existing file with an empty scrape.
5. After all companies, report how many company files were written/updated and the problem count per company.

Do not build the interview company filter in this skill. These files are the data for that later work.

## Scroll until loaded

Company lists are lazy. A first paint is not the full list.

Repeat until the problem-number count is **unchanged for 3 consecutive** scroll+wait cycles:

1. Count distinct problem numbers currently in the DOM (CDP `Runtime.evaluate` with `returnByValue: true`, expression below).
2. Scroll the **list container** to the bottom (overflow parent of the problem rows), not only the window. Then `browser_scroll` `direction: "down"` with a large `amount` (e.g. 2000) as a fallback.
3. Wait for the DOM to grow (short CDP poll / snapshot). Compare counts.

If the count is still `0` after several cycles, stop that company and ask — do not write an empty file.

**Count / extract (CDP):**

```javascript
(() => {
  const seen = new Set();
  const problems = [];
  for (const a of document.querySelectorAll('a[href*="/problems/"]')) {
    const t = (a.textContent || "").trim();
    const m = t.match(/^(\d+)\.\s/);
    if (!m) continue;
    const n = parseInt(m[1], 10);
    if (seen.has(n)) continue;
    seen.add(n);
    problems.push(n);
  }
  return { count: problems.length, problems };
})()
```

**Scroll the lazy container (CDP):**

```javascript
(() => {
  const a = document.querySelector('a[href*="/problems/"]');
  let el = a;
  while (el && el !== document.body) {
    const s = getComputedStyle(el);
    if (/(auto|scroll)/.test(s.overflowY) && el.scrollHeight > el.clientHeight + 20) {
      el.scrollTop = el.scrollHeight;
      return { mode: "container", scrollTop: el.scrollTop, scrollHeight: el.scrollHeight };
    }
    el = el.parentElement;
  }
  window.scrollTo(0, document.body.scrollHeight);
  return { mode: "window", y: window.scrollY };
})()
```

**Companies on the problem set (CDP), after expanding the right-hand list:**

```javascript
(() => {
  const seen = new Set();
  const companies = [];
  for (const a of document.querySelectorAll('a[href*="/company/"]')) {
    const href = (a.href || "").split("#")[0];
    const m = href.match(/\/company\/([^/?]+)/i);
    if (!m) continue;
    const slug = decodeURIComponent(m[1]).toLowerCase();
    if (seen.has(slug)) continue;
    seen.add(slug);
    companies.push({ slug, name: (a.textContent || slug).trim(), url: href });
  }
  return companies;
})()
```

## Save

From the repo root, after each company (stdin JSON). Existing files are updated (union of `problems`, latest `url` / `name` / `favoriteSlug`):

```bash
python3 .agents/skills/update-leetcode-companies/scripts/save.py <<'EOF'
{"slug":"google","name":"Google","url":"https://leetcode.com/company/google/?favoriteSlug=google-thirty-days","problems":[1,2,3]}
EOF
```

Writes `context-leetcode-companies/{level}/{slug}.json` when `levels.json` maps the slug, otherwise `context-leetcode-companies/{slug}.json`, and refreshes `context-leetcode-companies/index.json`.

Do not `Read()` huge HTML dumps. Do not invent missing numbers.

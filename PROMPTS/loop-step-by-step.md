# Loop: Step-by-step from `context/`

One tick = one problem. Read this file and [`loop-step-by-step.track.json`](loop-step-by-step.track.json) on every tick.

## Invoke

```
/loop Follow PROMPTS/loop-step-by-step.md. One context problem per tick. Update PROMPTS/loop-step-by-step.track.json before you finish the tick.
```

## Goal

Build a harness **step-by-step** session (`content/coaching/{slug}/`) from the problem named in `next` in the tracking JSON.

Use `.agents/skills/harness` (section 3) and `.agents/skills/harness/reference.md`. Match [`content/coaching/two-sum/`](../content/coaching/two-sum/) for shape. File the session into `category` + `subcategory` (see **File into** below).

## Each tick

1. Read [`loop-step-by-step.track.json`](loop-step-by-step.track.json). If `exhausted` is `true`, stop the loop and say the queue is finished.
2. If `context/doocs-leetcode` is missing, run `bash context/clone.sh` from the repo root, then continue.
3. Resolve sources for `next.repo` + `next.id` using **Problem IDs** below. Read the writeup and at least one solution.
4. Derive a kebab-case `slug` from the problem title (`0001.Two Sum` → `two-sum`).
5. If `content/coaching/{slug}/` already exists, do **not** overwrite. Append to `skipped` with `"reason": "slug_exists"` and advance `next`.
6. Otherwise create:
   - `content/coaching/{slug}/meta.php` — `title`, `summary`, `category`, `subcategory`, `topic` (`{category} · {subcategory}`), `tags`, and `leetcode` when **LeetCode number** applies
   - `content/coaching/{slug}/tree.php` — deterministic graph: `start`, readable `choices[].label`, at least one `wrong` leaf with `rewind_to`, a `success` leaf. No randomness, no live AI, no breadcrumbs file.
7. Teach the actual approach from `context/` (complexity, key invariant, common trap). English UI copy even if the source is Chinese.
8. Advance the cursor (below) and write the tracking JSON (pretty-printed, 2-space indent).
9. Stop. Do not start a second problem in the same tick.

## Repos (alphabetical)

Walk this list in order. Do not reorder.

1. `doocs-leetcode`
2. `hello-algo`
3. `labuladong-algorithm`
4. `leetcode-master`
5. `neetcode-leetcode`
6. `walkccc-leetcode`

## Problem IDs

IDs are paths relative to `context/<repo>/`, `/` separators, sorted with `LC_ALL=C`.

| Repo | What counts as one problem | Source file |
|------|----------------------------|-------------|
| `doocs-leetcode` | Directory `solution/<bucket>/<NNNN.Name>/` that has `README.md` or `README_EN.md`. Skip `images`. | Prefer `README_EN.md`, else `README.md`, plus a `Solution.py` / `Solution.js` if present |
| `hello-algo` | `en/docs/chapter_*/*.md`. Skip `index.md`. Skip chapters `chapter_appendix`, `chapter_preface`, `chapter_paperbook`, `chapter_reference`, `chapter_hello_algo`, `chapter_introduction` | That markdown file |
| `labuladong-algorithm` | `*.md` under the series folders (`动态规划系列`, `数据结构系列`, `高频面试系列`, `算法思维系列`, `多语言解法代码`). Skip `README.md` | That markdown file |
| `leetcode-master` | `problems/*.md` | That markdown file |
| `neetcode-leetcode` | `python/*.py` only (other language folders are the same problems) | That `.py` file; optional matching `articles/` writeup |
| `walkccc-leetcode` | Directory `solutions/<N. Title>/` | Prefer `*.py`, else `*.cpp`, else `*.java` |

## Advance `next`

After this tick’s ID is in `completed` or `skipped`:

1. List IDs for `next.repo` with `LC_ALL=C` sort.
2. Take the first ID **strictly after** the ID you just processed.
3. If none remain, set `next.repo` to the following name in **Repos**. Set `next.id` to that repo’s first ID.
4. If there is no following repo, set `exhausted` to `true` and `next` to `null`.

Keep `cursor.repo` / `cursor.last_id` equal to the problem you just processed.

`completed` / `skipped` entries:

```json
{
  "repo": "doocs-leetcode",
  "id": "solution/0000-0099/0001.Two Sum",
  "slug": "two-sum",
  "title": "Two Sum",
  "reason": "slug_exists"
}
```

(`reason` only on `skipped`.)

## File into category / subcategory

Every session `meta.php` must set:

| Key | Value |
|-----|--------|
| `category` | `LeetCode`, `Algorithms`, `Data Structures`, `System Design`, or `Harness` |
| `subcategory` | One primary pattern or structure (`Arrays`, `Trees`, `Dynamic Programming`, `Binary Search`, `Stack`, …) |
| `topic` | `{category} · {subcategory}` |
| `leetcode` | Integer id for numbered LeetCode problems; omit otherwise. Never put it in `title`. |

How to pick `category`:

| Source | `category` |
|--------|------------|
| Numbered LeetCode problem / LC writeup | `LeetCode` |
| Structure as a data type (stack, queue, heap, linked list, hash map as the structure) | `Data Structures` |
| Technique, complexity, or algorithm family | `Algorithms` |
| Distributed / SD prompt | `System Design` |

`subcategory` is the main pattern the session teaches. Example: Two Sum approach tree → `LeetCode` / `Arrays`.

## LeetCode number

When the last path segment of `next.id` starts with digits and a dot (`0001.Two Sum`, `158. Title`), set `'leetcode' => N` with that integer and no leading zeros (`1`, `158`). Omit the key when the source is not a numbered LeetCode problem (hello-algo chapters, labuladong essays, 剑指 Offer, LCR, …).

Never put the number in `title`. The app shows `LeetCode N` on its own row.

## Do not

- Overwrite existing `content/coaching/{slug}/`
- Commit unless the user asks
- Add PHP routes or UI
- Process more than one problem per tick

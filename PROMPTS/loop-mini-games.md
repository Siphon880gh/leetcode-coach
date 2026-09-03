# Loop: Mini games from `context/`

One tick = one candidate. Read this file and [`loop-mini-games.track.json`](loop-mini-games.track.json) on every tick.

## Invoke

```
/loop Follow PROMPTS/loop-mini-games.md. One context problem per tick. Create a mini game only when the problem has a clear interactive mechanic. Update PROMPTS/loop-mini-games.track.json before you finish the tick.
```

## Goal

Find problems in `context/` that can become a small playable **mini game**, then create `content/games/{slug}/` with the harness.

Use `.agents/skills/harness` (section 2). For web/2d craft, also use `.agents/skills/game-development-sickn33`. Match [`content/games/two-sum-pointers/`](../content/games/two-sum-pointers/) for shape: `meta.php` + self-contained `index.html`. File the game into `category` + `subcategory` (see **File into** below) so it shows up in the Mini games browse accordion and tile breadcrumbs.

## When to create vs skip

Create a game only if the writeup has **one** mechanic a learner can click, drag, or step through in a tiny page, for example:

- Two pointers / sliding window on an array
- Hash map “seen” / complement
- Stack / queue push-pop
- Tree DFS/BFS walking nodes
- Graph visit / queue
- Binary search lo/hi
- Linked-list pointer motion

Skip (still advance `next`) when the source is theory-only, a huge DP recap with no single board, a language-basics page, or a problem whose state is too large to show. Use `"reason": "no_mechanic"`.

## Each tick

1. Read [`loop-mini-games.track.json`](loop-mini-games.track.json). If `exhausted` is `true`, stop the loop and say the queue is finished.
2. If `context/doocs-leetcode` is missing, run `bash context/clone.sh` from the repo root, then continue.
3. Resolve sources for `next.repo` + `next.id` using **Problem IDs** below. Read the writeup and at least one solution.
4. Decide create vs skip using **When to create vs skip**.
5. If creating: derive kebab-case `slug` from the title plus the mechanic (`two-sum` + hash map → `two-sum-pointers`). If `content/games/{slug}/` exists, skip with `"reason": "slug_exists"` (do not overwrite).
6. Otherwise write:
   - `content/games/{slug}/meta.php` — `title`, `summary`, `category`, `subcategory`, `topic` (`{category} · {subcategory}`), `tags`, optional `entry`, and `leetcode` when **LeetCode number** applies
   - `content/games/{slug}/index.html` — one idea, inline CSS/JS, playable without a build step
7. English UI copy even if the source is Chinese. The game should make the `context/` approach visible (pointers, set, stack), not only quiz for the answer.
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
  "slug": "two-sum-pointers",
  "title": "Two Sum",
  "reason": "no_mechanic"
}
```

(`reason` only on `skipped`.)

## File into category / subcategory

Every game `meta.php` must set:

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

`subcategory` is the mechanic the game teaches. Example: Two Sum complement drill → `LeetCode` / `Arrays`. A binary-search lo/hi board → `Algorithms` / `Binary Search`.

## LeetCode number

When the last path segment of `next.id` starts with digits and a dot (`0001.Two Sum`, `158. Title`), set `'leetcode' => N` with that integer and no leading zeros (`1`, `158`). Omit the key when the source is not a numbered LeetCode problem (hello-algo chapters, labuladong essays, 剑指 Offer, LCR, …).

Never put the number in `title`. The app shows `LeetCode N` on its own row.

## Do not

- Overwrite existing `content/games/{slug}/`
- Force a game when there is no interactive mechanic
- Commit unless the user asks
- Add PHP routes or UI
- Process more than one problem per tick

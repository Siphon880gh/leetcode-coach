Integer array `nums` (length up to `2×10⁵`, values may be negative) and target `k`. Return the **maximum length** of a contiguous subarray that sums to `k`, or `0` if none. `[1,-1,5,-2,3]`, `k = 3` → `4` (`[1,-1,5,-2]`). `[-2,-1,2,1]`, `k = 1` → `2`.

## First index of each prefix; not a shrinking window

Minimum Size Subarray Sum (209) needs **positive** numbers so a two-pointer window is monotone. Subarray Sum Equals k (560) **counts** how many subarrays hit `k`. Here you want the **longest** one, and negatives make the window non-monotone.

Walk a running prefix `s`. Hash map `d` stores the **first** index where each prefix appeared; seed `d[0] = -1` so a prefix that itself equals `k` has length `i − (−1)`. At index `i`, if `s − k` is in `d`, the subarray after that earlier index sums to `k`; length is `i − d[s − k]`. Then, only if `s` is **new**, set `d[s] = i`. Keeping the earliest `s` maximizes later lengths. Same prefix later would shorten the span.

Do not overwrite an earlier prefix index. Do not two-pointer shrink as in 209. Do not return a count (560).

**Time:** O(n)  
**Space:** O(n)

> [!ui-builder] Mini game
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches [INPUT_TOPIC]. Place it under content/games/[INPUT_SLUG]/. Follow meta.php + index.html. Use .agents/skills/game-development-sickn33 for web/2d craft if needed.

> [!ui-builder] Step-by-step
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a step-by-step session for [INPUT_TOPIC] under content/coaching/[INPUT_SLUG]/. Include branching choices with clear labels, at least one wrong-path leaf with rewind_to, and a success leaf. Follow the tree.php contract so Step back and the Path visualizer work.

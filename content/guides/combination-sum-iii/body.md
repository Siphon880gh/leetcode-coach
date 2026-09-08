Find every combination of **exactly** `k` distinct integers from `1` through `9` that sum to `n`. Each digit at most once. Any order. `2 ≤ k ≤ 9`, `1 ≤ n ≤ 60`. `k = 3`, `n = 7` → `[[1,2,4]]`. `k = 3`, `n = 9` → `[[1,2,6],[1,3,5],[2,3,4]]`. `k = 4`, `n = 1` → `[]` (smallest four-digit sum is 10).

## Take or skip the next digit; length must be k

Combination Sum reuses the same index. Combination Sum II spends an index and skips equal values at one depth. Combinations is `C(n, k)` with no target. Here the pool is always `1 .. 9` and you must hit both the sum **and** the count.

`dfs(i, remain)` with a path `t`. If `remain == 0`, keep a copy only when `len(t) == k`, then return. If `i > 9`, or `i > remain`, or `len(t) ≥ k`, prune. Otherwise: push `i`, `dfs(i + 1, remain − i)`, pop; then skip with `dfs(i + 1, remain)`. Starting at `i = 1` keeps paths increasing, so you never emit `[2,1,4]` as a second copy of `[1,2,4]`.

Do not reuse a digit (`dfs(i, …)` like Combination Sum I). Do not accept a path whose length is not `k` even if the sum is `n`. Do not search past 9.

**Time:** O(2⁹) search (tiny) times O(k) to copy a path  
**Space:** O(k) for the path

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

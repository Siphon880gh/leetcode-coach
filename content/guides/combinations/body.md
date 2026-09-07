Return all k-combinations from `[1, n]`. `[1,2]` and `[2,1]` are the same. n ≤ 20.

`n = 4`, `k = 2` → `[[1,2],[1,3],[1,4],[2,3],[2,4],[3,4]]`.

## Choose or skip each integer

A `used[]` permutation tree emits both orders. Combination Sum may reuse a candidate to hit a target. Combination Sum II skips duplicate values. Here there is no target — only k distinct picks, so the next index only moves forward.

`dfs(i)` from 1: if `len(t) == k`, append a copy of `t` (the list is mutated on the way back). If `i > n`, return. Else append `i`, `dfs(i + 1)`, pop, then `dfs(i + 1)` without it. You may instead loop `j` from `i` to `n`, push `j`, `dfs(j + 1)`, pop. Return the list of combinations, not the count C(n, k).

**Time:** O(C(n, k) × k)  
**Space:** O(k)

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

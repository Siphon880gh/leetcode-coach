`candidates` may contain duplicates. Each **index** may be used at most once. Return unique combinations that sum to `target` (no duplicate multisets). `n ≤ 100`, `target ≤ 30`.

`[10,1,2,7,6,1,5]`, target `8` → `[[1,1,6],[1,2,5],[1,7],[2,6]]`. `[2,5,2,1,2]`, target `5` → `[[1,2,2],[5]]`.

## Skip twins at this depth

Combination Sum allowed `dfs(j, …)` so a value could be reused. Here call `dfs(j + 1, remain - candidates[j])` so that slot is spent.

Duplicates in the array would still emit `[1,7]` twice if you treat both `1`s as independent starts. Sort first. In the loop over `j` from `i`:

- If `j > i` and `candidates[j] == candidates[j - 1]`, `continue`.
- That skips a second pick of the **same value at the same depth**. Using two different `1`s in one path (`[1,1,6]`) is still allowed: those picks happen at different depths, so the second `1` is `j == i` for that call.

Prune when `remain < candidates[i]` after sorting. Same path-copy / push-pop skeleton as Combination Sum.

**Time:** O(2^n × n) worst case (copy a path of length n)  
**Space:** O(n) for the path

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

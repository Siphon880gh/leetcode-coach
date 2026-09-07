`candidates` are distinct positive integers. Return every unique multiset that sums to `target`. The same value may be used any number of times. Order of a combination does not matter. At most 150 answers. `target ≤ 40`.

`[2,3,6,7]`, target `7` → `[[2,2,3],[7]]`. `[2,3,5]`, target `8` → `[[2,2,2,2],[2,3,3],[3,5]]`.

## Reuse the same index

Unbounded knapsack, listed as combinations. Sort `candidates` first so you can stop when the remaining sum is smaller than `candidates[i]`.

`dfs(i, remain)`:

- `remain == 0` → copy the path into the answer.
- `remain < candidates[i]` → prune (later values are even larger).
- For `j` from `i` to the end: push `candidates[j]`, call `dfs(j, remain - candidates[j])`, pop.

The recursive call stays at `j`, not `j + 1`. That is how `2` can appear three times. Starting the loop at `i` (not `0`) keeps the path non-decreasing, so `[2,3]` and `[3,2]` are not both generated.

Combination Sum II forbids reuse and skips duplicate values. Here values are unique and reuse is required, so the only “skip” is the prune.

**Time:** exponential in how many picks fit in `target` (branching ≤ n, depth ≤ target / min)  
**Space:** O(target / min) for the path

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

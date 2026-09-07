An empty `m × n` grid. Start at `(0, 0)`, finish at `(m-1, n-1)`, only down or right. Return the number of routes. m, n ≤ 100.

`3 × 7` → 28. `3 × 2` → 3 (right-down-down, down-down-right, down-right-down).

## Add from above and left

Let `f[i][j]` be the number of paths to that cell. Seed `f[0][0] = 1`. Then `f[i][j]` is `f[i-1][j]` when `i > 0`, plus `f[i][j-1]` when `j > 0`. A path last stepped from exactly one neighbor, so the two incoming sets are disjoint — add, do not multiply.

DFS of every walk is exponential at 100 × 100. Unique Paths II adds stones; here every cell is open. The judge wants the count, not a list of move sequences. You can roll the first dimension and keep only a row of length n.

**Time:** O(m × n)  
**Space:** O(m × n), or O(n) with a rolling row

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

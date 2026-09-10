`m × n` binary grid; each `1` is a friend’s home. At least two friends. Return the minimum total **Manhattan** travel: for a meeting cell `p`, sum `|p.row − home.row| + |p.col − home.col|`. Meeting may be any cell (even empty). `[[1,0,0,0,1],[0,0,0,0,0],[0,0,1,0,0]]` → 6 (meet at `(0,2)`). `[[1,1]]` → 1. m, n up to 200.

## L1 separates; the 1-D optimum is the median

Shortest Path in a Grid would BFS one source. Here every home is a source, and the metric is Manhattan, so the 2-D sum **splits**: min over `x` of sum `|row_i − x|` plus min over `y` of sum `|col_i − y|`. In one dimension the point that minimizes the sum of absolute deviations is a **median**.

Scan the grid in row-major order: append each home’s row (already sorted) and its column (unsorted). Sort the column list. Let `k` be the number of homes. Meet at `rows[k / 2]` and `cols[k / 2]`. Sum `abs(v − median)` on each list and add.

Do not use the mean / centroid (that is Euclidean L2). Do not BFS from every cell (O((mn)²)). Do not forget to sort columns (rows are already ordered by the scan).

**Time:** O(m n + k log k) for the column sort  
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

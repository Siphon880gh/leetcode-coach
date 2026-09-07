Non-negative `m × n` grid. Start at `(0, 0)`, finish at `(m-1, n-1)`, only down or right. Return the smallest sum of cells on a path. m, n ≤ 200.

`[[1,3,1],[1,5,1],[4,2,1]]` → 7 (`1 → 3 → 1 → 1 → 1`). `[[1,2,3],[4,5,6]]` → 12.

## Min of up and left, plus the cell

Let `f[i][j]` be the cheapest cost to that cell. Seed `f[0][0] = grid[0][0]`. First row and first column have one parent, so they are prefix sums. Interior: `min(f[i-1][j], f[i][j-1]) + grid[i][j]`. Answer `f[m-1][n-1]`.

Unique Paths **adds** incoming way-counts. Here you **min** incoming costs, then add this cell. Greedy “step to the cheaper of down vs right” fails: from the start of the first example, down looks cheaper (1 vs 3) and can finish at 9, while `1 → 3 → 1 → 1 → 1` is 7. The judge wants that min sum, not a path list and not a route count.

**Time:** O(m × n)  
**Space:** O(m × n)

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

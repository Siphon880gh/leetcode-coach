Binary matrix of 0/1; largest rectangle of only 1s, return area. Rows and cols ≤ 200.

Example grid → 6. `[["0"]]` → 0. `[["1"]]` → 1.

## Histogram per row

Unique Paths counts routes. Search a 2D Matrix flattens a fully sorted grid. Set Matrix Zeroes writes 0s from original zeros. Largest Rectangle in Histogram is the 1D subroutine. Here you want a solid block of 1s sitting on each row as the floor.

Maintain `heights[j]`. On `'1'`, increment; on `'0'`, reset to 0 — a 0 breaks the column, so the bar cannot stand on that floor. After each row, `ans = max(ans, largestRectangleArea(heights))`. Return the max area over all row-histograms — an integer, not a mutated matrix.

**Time:** O(m × n)  
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

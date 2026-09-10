Design `Vector2D`: `next()` and `hasNext()` over a 2D list `vec` in row-major order. `next` is only called when `hasNext` is true. `[[1,2],[3],[4]]` yields 1, 2, 3, then `hasNext` true, true, 4, then false. Up to 200 rows, 500 cols, 10⁵ calls.

## Two indices; skip empty inner lists

Flatten Binary Tree to Linked List (114) mutates a tree. Flatten Nested List Iterator (341) walks nested integers. Here the shape is a list of lists, some of which may be **empty**. Copying every integer into one array at construct works but uses extra O(N) memory up front.

Keep `i` (row) and `j` (column), both start at 0. `forward()`: while `i` is in range and `j ≥ len(vec[i])`, increment `i` and reset `j` to 0. `hasNext`: `forward()`, then `i` still in range. `next`: `forward()`, take `vec[i][j]`, then `j` plus one.

Do not read `vec[i][j]` before skipping a spent or empty row (`[[],[1]]` would crash or skip 1). Do not assume every inner list has length at least 1. Do not flatten the tree problem (114).

**Time:** amortized O(1) per call (each cell and empty row is skipped once)  
**Space:** O(1) extra besides storing `vec`

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

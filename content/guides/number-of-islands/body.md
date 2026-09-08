`m` by `n` grid of characters `'1'` (land) and `'0'` (water). An island is 4-connected land (up, down, left, right — not diagonal). Edges of the grid are water. Return how many islands. First sample is one blob. Second sample is three. Up to 300 by 300.

## Paint the component, then count plus one

Right Side View walked a tree by depth. Surrounded Regions flood-fills from the **border**. Here you flood from every unvisited land cell.

Scan every cell. If you see `'1'`, that is a new island: add 1, then DFS or BFS through 4-neighbors that are still `'1'`, writing `'0'` (or a visited mark) so you never count them again. Diagonals stay separate islands. Cells are characters, not integers — compare to `'1'`.

Union-find twin: union adjacent lands, then count roots. Same components. Worst-case extra space is the recursion stack or the BFS queue on a full-land grid.

**Time:** O(m n)  
**Space:** O(m n) worst-case stack or queue

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

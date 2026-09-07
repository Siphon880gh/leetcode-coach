Walk every cell of an `m × n` grid in clockwise spiral order and return that list. `m`, `n` ≤ 10.

`[[1,2,3],[4,5,6],[7,8,9]]` → `[1,2,3,6,9,8,7,4,5]`. `[[1,2,3,4],[5,6,7,8],[9,10,11,12]]` → `[1,2,3,4,8,12,11,10,9,5,6,7]`.

## Turn when the next cell is blocked

Keep a heading `k` through `dirs = (0, 1, 0, -1, 0)`: right, down, left, up. Each step: emit the current cell, mark it visited, peek one step ahead. If that peek is out of bounds or already visited, rotate `k = (k + 1) % 4`. Then always take one step with the (possibly new) heading.

Loop exactly `m × n` times so the center is included, not just the outer frame. `vis` is required: after the first lap the inward cell is still a legal index.

Shrinking four walls (top, bottom, left, right) is the same idea without a `vis` grid. A sentinel on visited cells (values sit in `[-100, 100]`) also works if you restore afterward. This is not a maze DFS and not Rotate Image — the grid can be rectangular and the heading is fixed clockwise.

**Time:** O(m × n)  
**Space:** O(m × n) for `vis`, or O(1) with a sentinel or shrinking walls

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

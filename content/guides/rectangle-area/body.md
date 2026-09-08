Two axis-aligned rectangles: A by bottom-left `(ax1, ay1)` and top-right `(ax2, ay2)`, B the same with `b`. Return the **union** area (overlap counted once). Coords in `−10⁴ .. 10⁴`. Sample `A = [−3,0]–[3,4]`, `B = [0,−1]–[9,2]` → 45. Identical squares of side 4 → 16.

## A plus B minus `max(w, 0) × max(h, 0)`

Maximal Rectangle / Largest Rectangle in Histogram scan a grid of bars. Maximal Square is DP on cells. Here there are only two boxes; no grid.

Area of A: `(ax2 − ax1) × (ay2 − ay1)`. Same for B. Overlap width: `min(ax2, bx2) − max(ax1, bx1)`. Overlap height: `min(ay2, by2) − max(ay1, by1)`. If either is negative, they miss on that axis — treat as 0. Subtract that product from `A + B`.

Do not add the overlap twice (plain `A + B` when they intersect). Do not return only the overlap. Do not assume they always overlap. Rectilinear means sides parallel to the axes — no rotation.

**Time:** O(1)  
**Space:** O(1)

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

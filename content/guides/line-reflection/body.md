`n` points on the plane. True iff there is a line parallel to the y-axis that reflects the set onto itself. Repeated points are allowed. `[[1,1],[-1,1]]` → true (`x = 0`). `[[1,1],[-1,-1]]` → false (different y). Up to 10^4 points.

## Put points in a set; partner is `s − x`

The leftmost and rightmost x-coordinates must map to each other, so the only candidate axis is the vertical line at `(minX + maxX) / 2`. Equivalently, every point `(x, y)` must have `(s − x, y)` in the set, where `s = minX + maxX` (stay in integers; do not divide).

Build a set of unique `(x, y)`, then check the partner for every original point. Do not try every pair of points as a possible axis. Do not allow a horizontal or diagonal mirror. Same x with two y values still needs each y’s partner independently.

Time: O(n)  
Space: O(n)

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

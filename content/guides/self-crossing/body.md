Integer array `distance`. Start at `(0, 0)`. Move `distance[0]` north, then west, south, east, and so on (counter-clockwise). True iff the path ever crosses itself. `[2,1,1,2]` → true (meets at `(0, 1)`). `[1,2,3,4]` → false (growing spiral). `[1,1,1,2,1]` → true (back to the origin). Length up to 1e5; each step up to 1e5.

## Only three ways the current edge can hit the past

You cannot stamp every lattice point: a single step can be 1e5 long. A CCW spiral only collides with a few recent edges. For `i` from 3 onward (`d = distance`):

1. Fourth hits first: `d[i] ≥ d[i−2]` and `d[i−1] ≤ d[i−3]` (the new north/south is long enough and the west/east is short enough to overlap the segment two turns back).
2. Fifth meets first: `i ≥ 4`, `d[i−1] == d[i−3]`, and `d[i] + d[i−4] ≥ d[i−2]` (the fifth edge lands on the first).
3. Sixth crosses first: `i ≥ 5`, the inner rectangle conditions (`d[i−2] ≥ d[i−4]`, `d[i−1] ≤ d[i−3]`, `d[i] ≥ d[i−2] − d[i−4]`, `d[i−1] + d[i−5] ≥ d[i−3]`).

If none fire, the path never crosses. An ever-growing spiral (`[1,2,3,4,…]`) stays false.

Do not simulate a hash set of visited cells. Do not treat this as polygon winding or ray casting. Do not only check adjacent segments (crossings skip a turn).

Time: O(n)  
Space: O(1)

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

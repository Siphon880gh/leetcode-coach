Buildings `[left, right, height]`, grounded at 0, already sorted by left. Return key points of the outer contour, sorted by x: each is the left end of a horizontal run, last point y = 0. No two consecutive equal heights. `n ≤ 10⁴`. `[[2,9,10],[3,7,15],[5,12,12],[15,20,10],[19,24,8]]` → `[[2,10],[3,15],[7,12],[12,0],[15,10],[20,8],[24,0]]`. Two abutting height-3 blocks `[[0,2,3],[2,5,3]]` → `[[0,3],[5,0]]` (no dip to 0 at x = 2).

## Live max height on a sorted x-scan

Merge Intervals only unions ranges. Largest Rectangle in Histogram is bars on a line. Here overlapping rectangles change the **max** y as x moves.

Collect every left and right x, sort. Walk those x values. A max-heap (or priority queue) holds active buildings: when `left ≤ x`, push `(height, right)`; while the heap top’s `right ≤ x`, pop (the building is over). Current height is the heap max, or 0 if empty. If that height equals the last emitted y, skip; else append `[x, height]`. Lazy heap: leave a stale top until its right is past `x`, then pop.

Do not emit every building corner. Do not output a 0 between two touching same-height buildings. Do not leave consecutive equal y values. Segment-tree / discrete max on compressed x is the same contour; the heap scan is the usual interview write-up.

**Time:** O(n log n)  
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

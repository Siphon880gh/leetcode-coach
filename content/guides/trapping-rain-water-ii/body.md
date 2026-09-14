An `m × n` height map (each side at most 200). Return how much water the 2D terrain traps. `[[1,4,3,1,3,2],[3,2,1,3,2,4],[2,3,3,2,3,1]]` → `4`. The inner 5×5 bowl example traps `10`.

## Min-heap BFS from the rim

Water cannot sit on the border. Push every border cell `(height, i, j)` into a min-heap and mark it seen. While the heap is nonempty, pop the lowest wall `h`. For each unseen 4-neighbor: add `max(0, h − cell)` to the answer, mark seen, and push `(max(h, cell), x, y)`. The pushed height is the waterline that neighbor must respect — it never drops below the lowest enclosing wall seen so far.

That is why you pop the smallest wall first: the first time you reach a cell, the bottleneck rim is already known.

Trapping Rain Water (42) is a 1D two-pointer / stack problem. Pacific Atlantic Water Flow (417) also walks from borders, but it marks reachability, not trapped volume.

Do not run 42 independently on every row and every column and add those (overcounts and misses 2D basins). Do not start the heap from interior cells. Do not push the raw cell height when it is shorter than the current wall (the waterline would leak).

Time: O(m n log(m n))  
Space: O(m n)

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

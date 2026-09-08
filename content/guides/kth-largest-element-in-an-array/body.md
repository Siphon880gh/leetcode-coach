Return the `k`th largest value in `nums` in **sorted order**, not the `k`th distinct. `1 ≤ k ≤ n ≤ 10⁵`. `[3,2,1,5,6,4]`, `k = 2` → `5`. `[3,2,3,1,2,4,5,5,6]`, `k = 4` → `4` (descending 6, 5, 5, 4). Follow-up: without a full sort.

## Partition toward index n−k

Nth Highest Salary is SQL `DISTINCT` ranks. Find Peak is binary search on a slope. Full `sort` is O(n log n) and works, but `n` is 1e5 and the interview asks for average linear.

The `k`th largest is the element that would sit at index `n − k` after an ascending sort. Quickselect: pick a pivot (middle of the range), Hoare-partition so smaller values go left and larger right, then look at the split `j`. If `j < n−k`, the answer is in the right half; else in the left, including `j`. Recurse only that side. Average O(n); worst O(n²) unless you shuffle or use a guaranteed pivot.

Do not drop duplicates (this is not distinct). Do not return the `k`th smallest by forgetting `n − k`. Heap twin: a min-heap of size `k`; push each value, pop when the heap grows past `k`; the top is the `k`th largest — O(n log k) extra O(k).

**Time:** O(n) average Quickselect (O(n²) worst); heap O(n log k)  
**Space:** O(log n) recursion (O(k) for the heap)

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

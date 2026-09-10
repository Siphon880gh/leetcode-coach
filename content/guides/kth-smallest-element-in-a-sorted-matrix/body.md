An `n × n` matrix (`n` up to 300), each row and each column non-decreasing. Return the `k`th smallest in sorted order, not the `k`th distinct. `[[1,5,9],[10,11,13],[12,13,15]]`, `k = 8` → `13` (the sorted list is `1,5,9,10,11,12,13,13,15`). `[[-5]]`, `k = 1` → `-5`. Memory must beat flattening the whole matrix.

## Search the value; count from the bottom-left

The answer sits between `matrix[0][0]` and `matrix[n−1][n−1]`. Binary search that range. For a candidate `mid`, count how many cells are `≤ mid`. Start at `(n−1, 0)`: if `matrix[i][j] ≤ mid`, the whole prefix of that column above `i` is also `≤ mid` (add `i + 1`) and step `j` right; else step `i` up. That walk is O(n). If the count is at least `k`, the answer is in `[left, mid]`; else `[mid + 1, right]`. `left` at the end is a matrix value because the search is a lower bound on “enough cells”.

A min-heap of row heads (same idea as Find K Pairs with Smallest Sums) also works, but uses O(n) extra memory. Flatten then sort uses O(n²) extra and fails the memory note. Kth Largest Element (215) is one unsorted array.

Do not skip duplicate 13s (this is not distinct). Do not count only one cell per column. Do not search indices instead of values — the matrix is not a flattened sorted array in row-major order (`12` sits before `13` in the last row while `13` already appeared above).

Time: O(n log(max − min)) value search, O(n) per count
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

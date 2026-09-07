Each row is sorted, and `matrix[i][0]` is greater than the last value of the previous row. Return whether `target` is in the grid in O(log(m × n)).

`[[1,3,5,7],[10,11,16,20],[23,30,34,60]]`, 3 → true. Same grid, 13 → false.

## Flatten, then lower bound

The whole grid is one increasing stream, so treat it as an array of length m × n. Binary-search the index range `[0, m × n − 1]`. Map `mid` to row `mid / n` and column `mid % n`.

If `matrix[x][y] >= target`, set `right = mid`; else `left = mid + 1`. After the loop, check equality: lower bound may land on the first value ≥ target (13 lands on 16, so false). A full scan is O(m × n). This is not Search in Rotated Sorted Array, not Search Insert Position (index), and not Search a 2D Matrix II (staircase when rows and columns are independently sorted).

**Time:** O(log(m × n))  
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

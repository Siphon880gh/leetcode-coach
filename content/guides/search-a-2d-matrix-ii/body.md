Each row is sorted left to right. Each column is sorted top to bottom. The next row does **not** start after the previous row’s last cell, so you cannot flatten like Search a 2D Matrix (74). Return whether `target` is in the grid. `m`, `n` up to 300. Sample grid, 5 → true; 20 → false.

## Staircase from bottom-left (or top-right)

Binary search each of the `m` rows is O(m log n) and is correct because every row is sorted. A full scan is O(m n). Flattening mid / n, mid % n is 74 and is wrong here: `matrix[0][4]` can be larger than `matrix[1][0]`.

The O(m + n) walk starts at the **bottom-left** `i = m−1`, `j = 0` (or the symmetric top-right). While in bounds:

- Equal → true.
- `matrix[i][j] > target` → everything below in this column is even larger, so `i` minus one (go up).
- Else the cell is too small → everything left in this row is even smaller, so `j` plus one (go right).

Fall off the board → false. Each step discards a row or a column. Do not start at top-left: both directions increase, so a miss does not tell you which way to go. Do not treat the whole matrix as one sorted array.

**Time:** O(m + n) staircase; O(m log n) per-row binary search  
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

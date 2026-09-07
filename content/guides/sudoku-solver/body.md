Fill every `.` on a 9×9 board so each row, column, and 3×3 box holds `1`–`9` once. The input is guaranteed to have exactly one solution. Write the answer in place.

Valid Sudoku only **checks** filled cells. This problem **places** digits.

## DFS over empty cells

Reuse the same three “already used” maps as Valid Sudoku: `row[i][d]`, `col[j][d]`, `box[k][d]` with `k = (i // 3) * 3 + (j // 3)`. Seed them from the given digits.

Collect the empty cells into a list `t`. Recurse on index `k` in that list:

- If `k == len(t)`, every hole is filled: stop (success).
- For cell `(i, j) = t[k]`, try digit `v` in `1..9` when all three flags are false.
- Write `v`, mark the three flags, recurse to `k + 1`.
- If that call did not finish the board, unmark and erase the cell (backtrack).

Once a recursive call returns success, do not try later digits — the problem promises one solution.

Trying digits on a full 9×9 scan each time also works, but walking a prebuilt hole list keeps the recursion depth equal to the number of dots.

**Time:** exponential in the number of empty cells (branching ≤ 9)  
**Space:** O(1) extra besides the recursion stack (81-bounded flags)

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

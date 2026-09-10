`m` by `n` board of `0` (dead) and `1` (live). Update **in place** to the next generation. Eight neighbors (including diagonals). Live with fewer than 2 or more than 3 live neighbors dies; live with 2 or 3 lives on; dead with exactly 3 live neighbors becomes live. All cells use the **current** generation together. Sample `[[0,1,0],[0,0,1],[1,1,1],[0,0,0]]` → `[[0,0,0],[1,0,1],[0,1,1],[0,1,0]]`. Up to 25 by 25. Void return.

## 2 and −1 keep the old live bit readable

Set Matrix Zeroes marks in a first pass so written zeros do not cascade. Number of Islands paints `'1'` to `'0'` because order does not matter. Here a write of `0` or `1` would change a later neighbor count.

Encode: `2` = live this generation, dead next; `−1` = dead this generation, live next. Count live neighbors by scanning the 3 by 3 window (including self) for `board[x][y] > 0`, then start `live = −board[i][j]` so the center is not counted. If the cell is live (`1`) and `live < 2` or `live > 3`, write `2`. If it is dead (`0`) and `live == 3`, write `−1`. Second pass: `2` → `0`, `−1` → `1`. A full copy of the board is correct but extra O(m n).

Do not update a cell to `0`/`1` in the counting scan. Do not use only 4-neighbors. Do not skip subtracting the center when the 3 by 3 window includes it.

**Time:** O(m n)  
**Space:** O(1) extra

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

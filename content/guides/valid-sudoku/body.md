A 9×9 board of digits `1`–`9` and `.`. Return whether the **filled** cells already obey Sudoku: no repeat in any row, any column, or any of the nine 3×3 boxes. Do not solve the puzzle. A valid board may still be unsolvable.

The classic false case is two `8`s in the same top-left box even when rows look fine.

## Seen in three places

You only need one walk of the 81 cells. Keep three boolean grids (or three sets of `(group, digit)`):

- `row[i][d]` — digit `d` already seen in row `i`
- `col[j][d]` — same for column `j`
- `box[k][d]` — same for box `k`

Box index is `k = (i // 3) * 3 + (j // 3)`: row-of-boxes times 3 plus column-of-boxes. Skip `.`. For a digit, if any of the three flags is already true, return false. Otherwise mark all three true.

Nine separate row scans plus nine column scans plus nine box scans also work, but they re-read the board. The triple-flag pass is the same check in one trip.

**Time:** O(1) — 81 cells  
**Space:** O(1) — 3 × 9 × 9 flags

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

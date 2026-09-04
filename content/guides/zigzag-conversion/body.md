Write `s` down a column of `numRows`, then diagonally up, then down again. Read row by row. `"PAYPALISHIRING"` with 3 rows becomes `"PAHNAPLSIIGYIR"`. If `numRows` is 1, the string is already the answer.

You do not need a full 2D grid of empty cells. Keep `numRows` lists (the rows) and a row index `i` that **bounces**.

## Simulation

Start `i = 0` and a direction `k` (the code uses `k = -1` so the first character, sitting on row 0, flips `k` to `+1` and then steps down). For each character:

1. Append it to row `i`
2. If `i` is 0 or `numRows - 1`, flip `k`
3. `i += k`

Join the rows.

**Time:** O(n) — one pass  
**Space:** O(n) — the row buffers

## 3 rows, `"PAYPALISHIRING"`

Rows collect `P A H N`, `A P L S I I G`, `Y I R`. Concatenate in that order.

On 4 rows the same bounce visits 0-1-2-3-2-1-0-… and yields `"PINALSIGYAHRPI"`.

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

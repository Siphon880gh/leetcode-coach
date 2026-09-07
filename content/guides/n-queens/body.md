Place `n` queens on an `n × n` board so none share a row, column, or diagonal. Return every distinct board as strings of `Q` and `.`. n ≤ 9.

`n = 4` has two solutions. `n = 1` is `[["Q"]]`.

## One row at a time, mark attacks

Exactly one queen per row, so `dfs(i)` only chooses a **column** `j` for row `i`.

Keep three boolean arrays:

- `col[j]` — column `j` already has a queen
- `diag[i + j]` — main diagonal (constant `i + j`)
- `anti[n - i + j]` — anti-diagonal (constant `n - i + j`)

If all three are free, write `Q`, mark them, recurse `i + 1`, then unmark and write `.`. When `i == n`, join each row and append a copy.

Checking every square against every earlier queen also works but repeats the same geometry. N-Queens II is this search with a counter instead of storing boards.

**Time:** O(n² × n!) to copy boards at the leaves  
**Space:** O(n²) for the grid plus O(n) marks

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

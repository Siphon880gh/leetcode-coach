`m` by `n` grid: `W` wall, `E` enemy, `0` empty. Place one bomb on a `0`. The blast follows the row and column until a wall. Return the most enemies one bomb can kill. First example → 3. Second (`WWW` / `000` / `EEE`) → 1. `m, n` up to 500. No empty cell → 0.

## Running enemy counts, reset at W

For each cell, add four running totals of `E` since the last `W`:

- each row left to right, then right to left
- each column top to bottom, then bottom to top

Walls zero the runner. Enemies increment it. Empties still receive the current total (you can see those enemies from here). After all four passes, `kill[i][j]` is how many enemies a bomb at `(i, j)` would hit. Take the max among cells that are actually `0`.

Do not place on `E` or `W`. Do not count past a wall. Do not flood-fill (this is axis-aligned rays, not 4-neighbor spread). Scanning four directions from every empty cell is `O(m n (m + n))` and is the trap at 500 by 500.

Time: O(m n)  
Space: O(m n) for the kill grid

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

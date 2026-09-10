`m` by `n` grid, values `0` / `1` / `2`. Empty land is passable, buildings and obstacles are not. Place a house on a `0` that can 4-walk to **every** building, minimizing the sum of those path lengths. Impossible → `−1`. Sample `[[1,0,2,0,1],[0,0,0,0,0],[0,0,1,0,0]]` → 7 (cell `(1,2)`). `[[1,0]]` → 1. `[[1]]` → `−1`. `m`, `n` up to 50. At least one building.

## Multi-source BFS from buildings, not the 296 median

Best Meeting Point (296) is Manhattan with no walls: median row and column. Walls and Gates (286) BFS from every gate into empty rooms. Here walls **and** buildings block, and you must reach **all** buildings, so the 296 median can sit behind a `2`.

Count buildings `B`. For each `1`, BFS only into cells that are `0`. The first time you visit a cell in this BFS, add the current distance into `dist[r][c]` and increment `cnt[r][c]`. After every building, scan empty cells with `cnt == B` and take the min `dist`. None → `−1`.

Do not walk through `1` or `2`. Do not use Manhattan (a `2` can block the taxicab path). Do not require the house to sit on a `1`. Do not forget `cnt == B` (a landlocked `0` may see only some buildings).

**Time:** O(B m n)  
**Space:** O(m n)

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

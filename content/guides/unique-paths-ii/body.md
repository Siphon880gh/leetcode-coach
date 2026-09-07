Same down-or-right count as Unique Paths, but `1` cells are obstacles you cannot enter. m, n ≤ 100.

`[[0,0,0],[0,1,0],[0,0,0]]` → 2. `[[0,1],[0,0]]` → 1.

## A 1 is a wall, return 0

`dfs(i, j)` is the number of paths from that cell to the finish:

- Off the board, or `obstacleGrid[i][j] == 1` → 0 (check the wall **before** treating the finish as a success).
- Open finish `(m-1, n-1)` → 1.
- Else `dfs(i+1, j) + dfs(i, j+1)`, memoized.

If the start or the finish itself is a 1, the answer is 0. Copying Unique Paths I and ignoring the 1s overcounts (the 3×3 center wall would still look like 6). A 1 is not “one extra path.” Cache each cell so the tree is O(m × n), not exponential.

Bottom-up is the same idea: write 0 on a wall, else add from above and left.

**Time:** O(m × n)  
**Space:** O(m × n)

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

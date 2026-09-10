`m` by `n` grid `rooms`: `−1` wall, `0` gate, `INF` (`2³¹ − 1`) empty. Fill each empty cell with the distance to the **nearest** gate. Unreachable stays `INF`. In place. Sample becomes `[[3,−1,0,1],[2,2,1,−1],[1,−1,2,−1],[0,−1,3,4]]`. `[[−1]]` stays. Up to 250 by 250.

## Start BFS from all gates together

Number of Islands floods each land blob to count components. Surrounded Regions floods from the **border**. Here every gate is a source at distance 0: the first time a room is reached is the shortest path, so one BFS is enough.

Enqueue every cell with `0`. Level by level, for each of four neighbors in bounds whose value is still `INF`, write the current distance `d` and enqueue. Do not walk into `−1` or into a cell already filled (that cell already has a closer or equal gate). A separate BFS from each empty room is O((m n)²). DFS from a gate can mark a long path first and miss a nearer gate.

**Time:** O(m n)  
**Space:** O(m n) queue worst case

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

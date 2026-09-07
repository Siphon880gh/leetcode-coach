Min path sum from the top of a triangle to the bottom. From index `j` you may step to `j` or `j+1` on the next row. Up to 200 rows; entries can be negative.

`[[2],[3,4],[6,5,7],[4,1,8,3]]` → `11` (`2+3+5+1`). `[[-10]]` → `-10`.

## Bottom-up: cell plus min of the two below

Minimum Path Sum 64 is a rectangle with only down and right. Unique Paths counts routes. Pascal I/II fill binomial rows, not a min. Greedy “always the smaller neighbor” can trap you: a cheap next step can sit above a costly bottom.

Let `f[i][j]` be the min sum from that cell to the bottom. Seed a row of zeros below the last triangle row. Loop `i` from `n-1` down to 0: `f[i][j] = triangle[i][j] + min(f[i+1][j], f[i+1][j+1])`. The recurrence needs both children already computed, so the apex is last. Return the integer `f[0][0]` — not the chosen cells `[2,3,5,1]`, not Unique Paths’ count, not Pascal’s nested rows.

You can collapse to one array of length `n+1` and overwrite `f[j]` with `min(f[j], f[j+1]) + triangle[i][j]` on the way up (O(n) extra).

**Time:** O(n²)  
**Space:** O(n²), or O(n) with a rolling row

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

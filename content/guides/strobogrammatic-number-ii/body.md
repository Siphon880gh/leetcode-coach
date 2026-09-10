Given `n`, return every strobogrammatic number of length `n` (any order). Same 180° rotate map as Strobogrammatic Number (246): 0↔0, 1↔1, 8↔8, 6↔9, 9↔6. `n = 2` → `["11","69","88","96"]`. `n = 1` → `["0","1","8"]`. `1 ≤ n ≤ 14`.

## Build length n from length n−2

246 **checks** one string. 248 **counts** how many lie in a numeric range. Here you **generate**. A length-`u` number is a length-`u−2` core with one rotate pair wrapped on both ends.

`dfs(u)`: if `u` is 0, return a list with one empty string. If `u` is 1, return `["0","1","8"]` (the only self-maps; 6 and 9 do not map to themselves, so they cannot sit in the middle of an odd length). Otherwise, for each core `v` from `dfs(u−2)`, append `1+v+1`, `8+v+8`, `6+v+9`, `9+v+6`. If `u ≠ n`, also append `0+v+0` — zeros are legal **inside**, not as the outermost digits of the finished `n`-length string (`00` is not a 2-digit answer). Call `dfs(n)`.

Do not emit leading zeros on the full length. Do not put 6 or 9 in the single middle slot. Do not only check one candidate (that is 246).

**Time:** exponential in n (output size)  
**Space:** O(n) recursion depth plus the answer list

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

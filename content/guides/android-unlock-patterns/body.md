3×3 lock grid, dots numbered 1..9. Count unique valid patterns whose length is at least `m` and at most `n` (both 1..9). Dots in a pattern are distinct. If a segment between two consecutive dots passes through the center of another dot, that midpoint must already be in the pattern. `m = n = 1` → 9. `m = 1`, `n = 2` → 65.

## Midpoint table, then DFS; fold by symmetry

Most hops are free (for example 2 to 9 does not go through the center of 5). The jumps that do: 1–3 through 2, 1–7 through 4, 1–9 through 5, 2–8 through 5, 3–7 through 5, 3–9 through 6, 4–6 through 5, 7–9 through 8. Store those as `cross[a][b]`. From cell `i` you may go to unused `j` if `cross[i][j]` is 0 or already visited.

DFS: mark `i`, if the current length is in `[m, n]` add 1, recurse to legal unused neighbors, unmark. Stop when length would exceed `n`. Corners `{1,3,7,9}` are equivalent; edge centers `{2,4,6,8}` are equivalent. Answer is four times a corner start, plus four times an edge start, plus a center start.

Do not skip the midpoint rule (1 to 3 without 2 is illegal). Do not count the same rotation as different if you already multiplied by four. Do not reuse a dot.

Time: a handful of 9-dot paths (tiny)  
Space: O(1) besides the recursion stack of depth 9

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

A row of `n` houses, `k` colors (`2 ≤ k ≤ 20`). Neighbors cannot share a color. `costs` is `n × k`; `costs[i][j]` paints house `i` with color `j`. Return the min total. `[[1,5,3],[2,9,4]]` → 5 (color 0 then 2, or 2 then 0). `n ≤ 100`.

## Rolling k totals; skip the same color

Paint House (256) is this problem with `k = 3` (three rolling integers). House Robber forbids adjacent takes; here every house is painted. Greedy “cheapest color on each house” can paint two neighbors the same.

`f` starts as row 0. For each later house, copy that row into `g`. For each color `j`, add `min(f[h] for h ≠ j)` to `g[j]`. Then `f = g`. After the last house, `min(f)`. Naive inner min is O(k) per color, O(n k²) overall — fine for these limits.

Follow-up O(n k): from the previous `f`, remember the smallest value, the second smallest, and which color held the min. Color `j` adds the min if `j` is not that color, else the second min. Same recurrence, one pass over k per house.

Do not recurse into kⁿ colorings. Do not reuse Paint House’s three named variables when k can be 20. Do not allow adjacent same color.

**Time:** O(n k²), or O(n k) with first/second min  
**Space:** O(k)

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

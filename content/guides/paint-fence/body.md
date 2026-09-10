`n` posts, `k` colors. Paint every post. You **may** use the same color on two neighbors, but **not** on three in a row. Return the number of paintings. `n = 3`, `k = 2` → `6` (all-red and all-green are illegal). `n = 1`, `k = 1` → `1`. `n = 7`, `k = 2` → `42`. Answer fits in 32-bit signed.

## Two counts: last pair different vs last pair same

Paint House (256) minimizes cost with **neighbors different**. Here neighbors **may** match once; the ban is a run of three. House Robber skip/take does not map to colors.

`f` = ways to paint through this post so the last two colors **differ**. `g` = ways so the last two **match**. First post: `f = k`, `g = 0` (no pair yet). For each later post:

- Different from the previous color: any of the other `k − 1` colors, from **any** valid prefix → `f' = (f + g) × (k − 1)`.
- Same as the previous color: only legal if that previous pair already differed (otherwise three in a row) → `g' = f`.

Return `f + g`. Roll two integers; no need for an n-array.

Do not forbid two consecutive same (too strict; `n = 3`, `k = 2` would undercount). Do not allow three in a row. Do not reuse Paint House’s three color-cost states.

**Time:** O(n)  
**Space:** O(1)

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

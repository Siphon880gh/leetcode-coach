How many structurally unique BSTs use each value `1..n` once. Return the count. `n ≤ 19`.

`n = 3` → `5`. `n = 1` → `1`.

## Catalan DP, count only

Unique BST II builds every forest (`n ≤ 8`). Unique Paths adds two incoming grid routes. Climbing Stairs adds `f[i-1] + f[i-2]`. Here you only need how many shapes, and left forests combine independently with right forests.

`f[0] = 1` (one empty tree). For each size `i` in `1..n`, try left size `j` in `0..i-1`; the right then has `i-j-1` nodes. Add `f[j] × f[i-j-1]` — every left shape pairs with every right shape. Return `f[n]`, an integer, not a list of roots.

**Time:** O(n²)  
**Space:** O(n)

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

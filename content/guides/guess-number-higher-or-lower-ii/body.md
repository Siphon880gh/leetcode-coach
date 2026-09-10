I pick a number in `1 .. n` (`n` up to 200). You guess. A miss costs that guess `x` dollars, then you are told higher or lower and keep going. Return the smallest bankroll that still wins no matter which number I picked. `n = 10` → `16`. `n = 1` → `0` (guess the only value, pay nothing). `n = 2` → `1` (guess 1; if wrong, pay 1 and take 2).

## Min over the first guess, max over the remaining side

This is not Guess Number Higher or Lower (374). There the API finds the pick; here you must budget the worst case. Binary search on the value is a strategy, not the optimum cash: a cheap first guess can leave an expensive remaining interval.

Let `f[i][j]` be the min cash to guarantee a win on the closed range `[i, j]`. `f[i][i] = 0`. For a longer range, try each first guess `k` in `[i, j]`. You pay `k`, then the opponent puts you on the costlier leftover, `max(f[i][k−1], f[k+1][j])`. Take the `k` that minimizes `k + that max`. Empty leftovers (when `k` is an endpoint) cost 0.

Fill by increasing length: walk `i` from `n−1` down to 1 and `j` from `i+1` to `n`, so both subranges are already known. Seed `f[i][j]` with “guess `j` first” (`j + f[i][j−1]`) then try the other `k`. Answer `f[1][n]`.

Do not return the sum of 1 through n. Do not assume the first guess must be the midpoint. Do not reuse 374’s `guess` API.

Time: O(n³)
Space: O(n²)

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

Least count of **perfect squares** that add to `n`. Squares are `1, 4, 9, 16, …`. `12` → `3` (`4+4+4`). `13` → `2` (`4+9`). `1 ≤ n ≤ 10⁴`.

## Squares as coins you may reuse

Coin Change (322) is unbounded knapsack on an arbitrary coin list. Here the coins are `i²` for `i = 1 .. floor(sqrt(n))`. Greedy “largest square first” fails: `12` as `9+1+1+1` uses four, but three `4`s win.

`f[j]` = fewest squares that sum to `j`. `f[0] = 0`, other `f` start as infinity. For each `i` from 1 through `sqrt(n)`, let `sq = i × i`. For `j` from `sq` to `n`: `f[j] = min(f[j], f[j − sq] + 1)` (use `i²` again — inner loop goes forward). Return `f[n]`.

Lagrange’s four-square theorem: every natural number is at most four squares. A number of the form `4^k (8m+7)` needs four; else check one square, then two, else three. That is O(sqrt(n)) math; the knapsack is the straightforward DP.

Do not greedy the largest square. Do not treat this as Add Digits (digital root). Do not use 0-1 knapsack (each square type may be used many times).

**Time:** O(n sqrt(n))  
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

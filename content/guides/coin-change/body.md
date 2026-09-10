Integer array `coins` (up to 12 denominations) and `amount` (0..10⁴). Return the **fewest** coins that sum to `amount`. Infinite supply of each coin. Impossible → `−1`. `[1,2,5]`, `11` → `3` (`5+5+1`). `[2]`, `3` → `−1`. `amount = 0` → `0`.

## Unbounded knapsack; inner loop goes forward

Greedy largest-first fails: coins `[1,3,4]`, amount `6` is two `3`s, not `4+1+1`. 0-1 knapsack (each coin once) is the wrong model. Coin Change II (518) **counts** combinations; this problem asks for a **minimum count**. Perfect Squares (279) is this same DP with coins `1, 4, 9, …`.

`f[j]` = fewest coins for amount `j`. `f[0] = 0`, other slots start as infinity. For each coin `x`, for `j` from `x` to `amount`: `f[j] = min(f[j], f[j − x] + 1)`. Forward `j` reuses `x` in the same pass. If `f[amount]` is still infinity, return `−1`.

Do not reverse the inner loop (that would be 0-1). Do not return the combination list unless asked — the count is enough. Do not treat `amount = 0` as impossible.

**Time:** O(m × amount)  
**Space:** O(amount)

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

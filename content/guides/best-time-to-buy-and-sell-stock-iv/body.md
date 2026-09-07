At most `k` buy-sell pairs; sell before you buy again. `k` from 1 to 100; `n` up to 1000. `k = 2`, `[2,4,1]` → 2. `k = 2`, `[3,2,6,5,0,3]` → 7 (2→6 then 0→3).

## k copies of the Stock III machine

Stock I is one pair. Stock II has no cap (sum every up-day). Stock III is exactly this machine with `k = 2` and four rolling variables. Here `k` is an argument. Count a transaction when you **buy**. `f[j][0]` = best cash after `j` buys, not holding. `f[j][1]` = holding after `j` buys.

Seed `f[j][1] = -prices[0]` for `j` from 1 through `k` (bought on day 0). Each later price `x`, walk `j` from `k` down to 1 so you do not reuse the same day’s updated `j-1` twice:

- cash: `f[j][0] = max(f[j][0], f[j][1] + x)` (sell)
- hold: `f[j][1] = max(f[j][1], f[j-1][0] - x)` (buy, spending one of the `k`)

Return `f[k][0]`. Using fewer than `k` trades is allowed (leftover `j` never beats a better smaller `j` in this setup). Same-day buy/sell is profit 0.

If `k` is at least `n // 2`, you can trade every rise — same as Stock II; skip the table.

**Time:** O(n k)  
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

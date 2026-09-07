At most two transactions; sell before you buy again. `n` up to 1e5.

`[3,3,5,0,0,3,1,4]` → `6`. `[1,2,3,4,5]` → `4`. `[7,6,4,3,1]` → `0`.

## Four states, return the second sale

Stock I is one pair — that first sample is `4` (buy `0`, sell `4`). Stock II has no cap, so it can take three rises and score `8`. Here `k` is 2, so the extra rise is illegal. Triangle and Unique Paths are other grids. You do not need a full n-by-k table: four rolling variables are enough.

Seed `f1 = f3 = -prices[0]`, `f2 = f4 = 0` (cash after first buy, first sell, second buy, second sell). Each later price, in this order:

`f1 = max(f1, -price)`  
`f2 = max(f2, f1 + price)`  
`f3 = max(f3, f2 - price)`  
`f4 = max(f4, f3 + price)`

Same-day buy/sell is profit 0 and does not hurt. Return `f4`, not `f2`: `f4` is after the second sale, and it never drops below a one-trade profit, so using only one trade is still allowed. You must not force two trades — `[1,2,3,4,5]` is `4` from a single hold, not `0`.

Return the integer — `6`, `4`, and `0` on the three samples — not Stock II’s `8`, and not the two deals as pairs.

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

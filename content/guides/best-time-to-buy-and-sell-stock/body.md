One buy, then one later sell. Return the max profit, or `0` if prices only fall. `n` up to 1e5.

`[7,1,5,3,6,4]` → `5` (buy `1`, sell `6`). `[7,6,4,3,1]` → `0`.

## Prefix min, then today minus that min

Stock II lets you add every uphill (`1→5` and `3→6` would be `7`) — here you may complete only one transaction. Buying on day 0 at `7` and selling last at `4` loses money. Triangle and Unique Paths are grid DP. Nested `i < j` over every pair is O(n²) and `n` is 1e5.

`ans` starts at `0`, `mi` at infinity. For each price `v`: first `ans = max(ans, v - mi)`, then `mi = min(mi, v)`. You must score `v - mi` **before** folding `v` into `mi`. If you min first, today vs today is `0` and the running max never sees a sale against a cheaper past day. Same-day buy and sell is not a useful trade.

Return the integer profit — `5` on the first sample, `0` on a strictly falling array — not the buy/sell days and not the pair of prices `[1, 6]`.

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

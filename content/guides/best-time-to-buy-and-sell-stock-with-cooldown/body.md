Daily `prices`. Unlimited buy/sell, one share at a time, **cooldown**: after you sell you cannot buy the next day. `[1,2,3,0,2]` → 3 (`buy, sell, cooldown, buy, sell`). `[1]` → 0. Length up to 5000.

## After a sell, the next buy is two days later

Stock II (122) lets you sell and buy on consecutive days. Stock I is one trade. Here the extra edge is a rest day after every sell.

Memo `dfs(i, holding)`: past the end → 0. Always skip (`dfs(i+1, holding)`). If holding, sell today: `prices[i] + dfs(i+2, 0)` (skip day `i+1`). If not holding, buy: `−prices[i] + dfs(i+1, 1)`. Answer `dfs(0, 0)`.

Bottom-up: `f[i][0]` cash, `f[i][1]` holding. `f[0][0] = 0`, `f[0][1] = −prices[0]`. Then cash = max(stay cash, sell from yesterday’s hold). Hold = max(stay hold, buy using cash from **two** days ago — `f[i−2][0] − prices[i]`, or `−prices[i]` when `i == 1`). Answer last day’s cash. Roll three integers if you want O(1) extra.

Do not use Stock II’s “sell then buy tomorrow.” Do not hold two shares. Do not skip the `i+2` jump after a sell.

**Time:** O(n)  
**Space:** O(n) table or O(1) rolling

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

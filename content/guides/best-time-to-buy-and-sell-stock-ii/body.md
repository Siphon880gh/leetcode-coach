As many trades as you want, but hold at most one share. Return max profit (`0` if prices only fall). Length up to 3e4.

`[7,1,5,3,6,4]` → `7` (`1→5` and `3→6`). `[1,2,3,4,5]` → `4`. `[7,6,4,3,1]` → `0`.

## Sum every positive adjacent gap

Stock I is one buy and one later sell — that sample would be `5` (buy `1`, sell `6`). Here you may sell and buy again, so the two disjoint rises add to `7`. Stock III caps at two trades. Triangle and Unique Paths are grids. This problem has no trade-count cap, only “one share at a time.”

For each consecutive pair, add `max(0, b - a)` and skip down days. A climb `[1,2,3,4,5]` is `(2-1)+(3-2)+(4-3)+(5-4)=4`, the same as buy first sell last. Same-day sell then buy is allowed, so a long climb equals many 1-day flips as an accounting trick — holding the whole climb is also valid and earns the same total. You are not forced to sell every day.

Return the integer profit — `7` on the first sample, `4` on a strict climb, `0` when prices only fall — not Stock I’s `5`, and not the trade list `[[1,5],[3,6]]`.

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

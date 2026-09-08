Houses in a **circle**: first and last are neighbors. `nums[i]` is cash; no two adjacent houses (including the wrap). Return the maximum. Length 1 to 100; values 0 to 1000. `[2,3,2]` → 3 (cannot take both 2s). `[1,2,3,1]` → 4 (first and third). `[1,2,3]` → 3. One house → that house.

## Two linear House Robber runs

House Robber was a line: skip or take-plus-two-back, rolled in two integers. Climbing Stairs counts 1-and-2 steps. Here the extra edge is `0` next to `n−1`. You cannot rob both ends, so the circle splits into two lines: houses `0 .. n−2` (drop the last) and `1 .. n−1` (drop the first). Run the linear helper on each range and take `max`. If `n == 1`, return `nums[0]` — both slices would be empty or overlapping incorrectly.

Do not run the linear DP on the whole array and hope the ends stay apart. Do not add `nums[0]` plus `nums[n−1]`. Greedy peaks still lose the same way as House Robber I.

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

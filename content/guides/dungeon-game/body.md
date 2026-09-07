Knight starts top-left, princess bottom-right. Only right or down. Health must stay at least 1 after every room. Negative cells hurt; positive cells heal. Return the minimum initial health. `[[-2,-3,3],[-5,-10,1],[10,30,-5]]` → 7 (right, right, down, down). `[[0]]` → 1. Grid up to 200 by 200.

## Work backward from the princess

Forward max-path (or Unique Paths / min path sum) fails: a huge heal later cannot rescue a 0 on the way, and greedy “avoid −10” is not the same as min start HP. BST Iterator is a tree stack. Factorial trailing zeroes counts 5s.

`dp[i][j]` = min HP you must have **before** taking this room, so you can still reach the end. From the end: dummy cells just past the last row/column hold 1 so entering the princess with 1 after her room is enough. Fill from bottom-right: `dp[i][j] = max(1, min(dp[i+1][j], dp[i][j+1]) - dungeon[i][j])`. The max-with-1 clamp means leftover heal never lets you start at 0.

Answer is `dp[0][0]`. Sample 7: you need 7 at the start so the path  −2, −3, 3, 1, −5 never dies.

**Time:** O(m n)  
**Space:** O(m n)

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

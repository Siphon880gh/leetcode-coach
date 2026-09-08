Houses in a line, `nums[i]` is cash. Rob a subset so no two chosen houses are adjacent. Return the maximum total. Length 1 to 100; values 0 to 400. `[1,2,3,1]` → 4 (first and third). `[2,7,9,3,1]` → 12 (2, 9, and 1). One house → that house.

## Linear DP, not greedy peaks

Rising Temperature was a SQL date join. Climbing Stairs **counts** sequences of 1 and 2. Here you **maximize** cash with a gap constraint. Taking every local max can lose: 2, 7, 9 wants 2+9, not 7 alone.

Let `f(i)` be the best using houses `0 .. i-1` (first `i` houses). `f(0) = 0`. `f(1) = nums[0]`. For `i > 1`: skip house `i-1` → `f(i-1)`; rob it → `f(i-2)` plus `nums[i-1]`. Take the max. Answer `f(n)`.

Only the last two `f` values matter: keep `prev2`, `prev1`. Uncached recursion is exponential; memoized `dfs(i)` = max(`nums[i]` plus `dfs(i+2)`, `dfs(i+1)`) is the same recurrence from the left.

**Time:** O(n)  
**Space:** O(1) rolling (O(n) if you store the whole `f` array or the memo table)

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

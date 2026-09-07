n stairs. Each move is 1 or 2 steps. Count distinct sequences. n ≤ 45.

`n = 2` → 2 (`1+1`, `2`). `n = 3` → 3 (`1+1+1`, `1+2`, `2+1`).

## Last step 1 or 2

Let `f[i]` be the number of ways to reach stair i. The last hop is either 1 (from i−1) or 2 (from i−2), so `f[i] = f[i-1] + f[i-2]`. Seed so `n = 1` returns 1. Roll two ints n times; extra space is O(1).

`1+2` and `2+1` are different sequences — the problem counts order, not the multiset of step sizes. Uncached DFS is exponential at n = 45. Unique Paths is an m × n board; this is a 1D Fibonacci count. The judge wants that integer, not a list of walks.

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

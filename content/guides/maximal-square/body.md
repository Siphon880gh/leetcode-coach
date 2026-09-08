`m` by `n` matrix of `'0'` / `'1'`. Return the **area** of the largest square of 1s (not the side). First sample → 4. `[["0","1"],["1","0"]]` → 1. `[["0"]]` → 0. Up to 300 by 300.

## Square DP, not a histogram rectangle

Number of Islands counts 4-connected blobs. Maximal Rectangle (85) allows non-square histograms. Here the shape must be a square.

Let `dp[i+1][j+1]` be the largest side whose lower-right corner is `(i, j)`. Pad a zero row and column so the first cell has neighbors. If `matrix[i][j]` is `'0'`, `dp` stays 0. If it is `'1'`, `dp = min(above, left, up-left) + 1`. Track `mx`, the max side. Return `mx × mx`. Cells are characters — compare to `'1'`. Returning `mx` alone fails the area spec. Brute checking every top-left and side is too slow at 300.

You can roll two rows (or one) because only the previous row is needed. Empty-looking all-zero grids correctly return 0.

**Time:** O(m n)  
**Space:** O(m n) full table, or O(n) rolling

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

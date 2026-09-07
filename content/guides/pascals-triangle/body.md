Return the first `numRows` of Pascal’s triangle. Each interior value is the two numbers directly above added. `numRows` is 1..30.

`5` → `[[1],[1,1],[1,2,1],[1,3,3,1],[1,4,6,4,1]]`. `1` → `[[1]]`, not `[1]`.

## 1s on the edge, pairwise from the finished row

Unique Paths returns one integer (grid walks). Unique BST I returns a Catalan count. Distinct Subsequences counts string ways. Next Right II mutates `.next` on a tree. Pascal II asks for a single row. Here you return the nested rows themselves.

Seed `f = [[1]]`. Repeat `numRows - 1` times: from the last row, build `g = [1]` + each adjacent pair summed + `[1]`, then append `g`. Ends of every row stay 1. The `2` in `[1,2,1]` is `1+1` from the row above — those two cells are already finished, so you never pairwise-sum the row you are still writing.

Do not overwrite the previous row in place to keep only one list (that is Pascal II). Keep every prior row in `f`. Return `f` — not a boolean, not a flattened `[1,1,1,2,1,…]`, and not only the last row `[1,4,6,4,1]`.

**Time:** O(n²)  
**Space:** O(n²) for the answer (extra work is O(1) beyond that)

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

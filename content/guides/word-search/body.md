Does `word` exist as a path of up/down/left/right cells, no cell twice? m, n ≤ 6.

`[["A","B","C","E"],["S","F","C","S"],["A","D","E","E"]]`, `"ABCCED"` → true, `"ABCB"` → false.

## DFS four ways, mark used

Unique Paths counts empty-grid routes. Sudoku fills digits. Word Search II returns a list of words with a trie. Here you match one given string on a letter grid.

From every cell, `dfs(i, j, k)`: if `k` is the last index, return `board[i][j] == word[k]`. If the cell mismatches, return false. Else write `"0"` (blocks reuse on this path), try four neighbors for `k + 1`, then put the letter back so later starts still see the original cell. Adjacent means 4-neighbors, not diagonals. `"ABCB"` is false: after A-B-C the first B is already used.

Return true if any start’s `dfs(i, j, 0)` succeeds — a boolean, not the path string.

**Time:** O(m × n × 3^k)  
**Space:** O(min(m × n, k))

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

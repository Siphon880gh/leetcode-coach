Minimum operations to turn `word1` into `word2`. Allowed ops: insert, delete, or replace one character. Lengths ≤ 500.

`"horse"` → `"ros"` is 3. `"intention"` → `"execution"` is 5.

## Min of insert, delete, replace

Let `f[i][j]` be the min cost to convert the first i letters of `word1` into the first j of `word2`. Borders: `f[i][0] = i` (i deletes) and `f[0][j] = j` (j inserts) — empty is not free.

If the current letters match, copy `f[i-1][j-1]` with no extra cost. Else take `min(f[i-1][j], f[i][j-1], f[i-1][j-1]) + 1`: delete, insert, replace. Answer `f[m][n]`.

This is a count, not Regular Expression Matching (boolean on a pattern with dot and star). LCS length is not the same: a replace costs 1 here, not two insert/deletes.

**Time:** O(m × n)  
**Space:** O(m × n)

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

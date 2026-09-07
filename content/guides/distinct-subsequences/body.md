Count distinct subsequences of `s` that equal `t` (keep order, skip letters). Lengths up to 1000. The answer fits in a 32-bit signed integer.

`s = rabbbit`, `t = rabbit` → `3`. `s = babgbag`, `t = bag` → `5`.

## Ways s can form t

Interleaving String is true/false on two sources. Edit Distance is a min cost. Unique Paths counts grid walks. Unique BST I counts tree shapes. Flatten rewires a tree.

`f[i][j]` = ways the first `i` characters of `s` form the first `j` of `t`. `f[i][0] = 1` for every `i` — one way to form the empty string: skip every letter of `s`. Always copy `f[i-1][j]` (skip `s[i-1]`). If `s[i-1] == t[j-1]`, also add `f[i-1][j-1]` (take that letter). Return `f[m][n]`, a count, not a boolean.

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

Is `s3` an interleaving of `s1` and `s2` — each source stays in order, letters may alternate. Lengths up to 100 + 100.

`aabcc` + `dbbca` → `aadbbcbcac` is true, `aadbbbaccc` is false. Empty + empty + empty is true.

## Take s1 or s2, memo

Concatenate `s1+s2` is one order, not every mix. Unique Paths counts grid walks. Scramble String swaps halves of one string. Greedy “take the first matching letter” dies on `aadbbbaccc`.

If `m + n ≠ |s3|`, return false. Else `dfs(i, j)`: leftover prefixes of `s1` and `s2` must form the rest of `s3`. If `i ≥ m` and `j ≥ n`, true. Let `k = i + j`. Recurse `i+1` when `s1[i] == s3[k]`, and/or `j+1` when `s2[j] == s3[k]`. Try both when both match — either source may unlock a later letter. Memo `(i, j)`. Return `dfs(0, 0)`, a boolean, not how many interleaves.

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

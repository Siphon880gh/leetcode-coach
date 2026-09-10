`mat1` is `m` by `k`, `mat2` is `k` by `n`. Return `mat1 × mat2` (always legal). Sample `[[1,0,0],[-1,0,3]]` × `[[7,0,0],[0,0,0],[0,0,1]]` → `[[7,0,0],[-7,0,3]]`. `[[0]]` × `[[0]]` → `[[0]]`. Dimensions up to 100; entries in `[-100, 100]`.

## Compress nonzero cells, then scatter products

Naive `ans[i][j] += mat1[i][t] × mat2[t][j]` for every `t` is correct and O(m n k), but most cells are zero, so most products are zero.

Compress each row to a list of `(col, val)` for nonzero `val`. Call those lists `g1` and `g2`. For each row `i` of `mat1`, for each pair `(t, x)` in `g1[i]`, for each pair `(j, y)` in `g2[t]`, add `x × y` into `ans[i][j]`. You only walk pairs that can change the answer. Dense worst case is still O(m n k); sparse input is cheaper.

Do not skip the shared dimension `k` (row of `mat1` must match row of `mat2` at the same `t`). Do not add cells as if this were matrix addition. Do not treat `mat2` as already transposed unless you built it that way.

**Time:** O(m n k) worst case  
**Space:** O(m n) for the answer, plus the compressed rows

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

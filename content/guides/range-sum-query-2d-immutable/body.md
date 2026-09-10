`m` by `n` integer matrix, **immutable**. Implement `NumMatrix`: constructor, then `sumRegion(row1, col1, row2, col2)` inclusive. Must be O(1) per query. Sample: `sumRegion(2,1,4,3)` → 8. Up to 200 by 200; up to 10⁴ queries.

## Two-D prefix with a dummy border

Range Sum Query - Immutable (303) is a 1-D prefix `s[right+1] − s[left]`. Looping rows and using a 1-D prefix on each row is O(m) per query and misses the O(1) spec. Fenwick / 2-D BIT is for **mutable** updates.

Pad `s` to `(m+1)` by `(n+1)` zeros. For each cell `(i, j)`:

`s[i+1][j+1] = s[i][j+1] + s[i+1][j] − s[i][j] + matrix[i][j]`

(above + left − overlap + this value). Then the rectangle from `(r1, c1)` to `(r2, c2)` is

`s[r2+1][c2+1] − s[r2+1][c1] − s[r1][c2+1] + s[r1][c1]`

The last plus puts back the top-left block that both strips subtracted. Dummy zeros make `r1 == 0` or `c1 == 0` just work.

Do not scan the rectangle at query time. Do not drop the `+ s[r1][c1]` (double-subtract). Do not treat this as 303’s 1-D formula.

**Time:** O(m n) build, O(1) per `sumRegion`  
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

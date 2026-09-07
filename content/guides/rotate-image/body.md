`n × n` matrix. Rotate 90° clockwise **in place**. Do not allocate a second n × n grid. n ≤ 20.

`[[1,2,3],[4,5,6],[7,8,9]]` → `[[7,4,1],[8,5,2],[9,6,3]]`.

## Reverse then transpose

The cell `(i, j)` must land at `(j, n-1-i)`. Two reflections compose that map:

1. Reverse rows (flip upside down): `(i, j)` → `(n-1-i, j)`.
2. Transpose on the main diagonal: `(n-1-i, j)` → `(j, n-1-i)`.

Swap `matrix[i][j]` with `matrix[n-1-i][j]` for `i` in `0 .. n/2`. Then swap `matrix[i][j]` with `matrix[j][i]` for `j < i` (stay strictly under the diagonal so you do not swap twice).

Transpose first then reverse each row is the same clockwise turn written in the other order. Cycling four cells `(i,j) → (j,n-1-i) → …` also works; the two-flip version is easier to get right.

**Time:** O(n²)  
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

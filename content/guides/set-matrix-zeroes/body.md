If a cell is 0, set its entire row and column to 0, **in place**. m, n ≤ 200.

`[[1,1,1],[1,0,1],[1,1,1]]` → `[[1,0,1],[0,0,0],[1,0,1]]`. `[[0,1,2,0],[3,4,5,2],[1,3,1,5]]` → `[[0,0,0,0],[0,4,5,0],[0,3,1,0]]`.

## Mark rows and cols first

A 0 you write in the same scan looks like an original 0 and then zeros extra lines. Scan once: if `matrix[i][j] == 0`, set `row[i]` and `col[j]`. Scan again: if either mark is set, write 0.

Two boolean arrays are O(m + n). A full copy is O(m × n) extra and is the follow-up’s “bad idea.” You can later reuse the first row and first column as the mark bits for O(1) extra. This is not Rotate Image (a 90° permutation) and not Unique Paths II (count routes around 1-walls). The method returns void.

**Time:** O(m × n)  
**Space:** O(m + n)

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

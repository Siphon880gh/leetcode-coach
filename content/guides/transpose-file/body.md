Transpose `file.txt`: every row has the same number of space-separated fields. Sample `name age` / `alice 21` / `ryan 30` becomes `name alice ryan` and `age 21 30`.

## One awk array, one string per column

Valid Phone Numbers keeps or drops whole lines. Word Frequency counts tokens. Rotate Image is a matrix in memory. Here the file is the matrix and `awk` walks fields.

`NF` is how many columns; `NR` is the row index. For each field `i` from 1 to `NF`: if this is the first row, `res[i]` is `$i`; else append a space and `$i` onto `res[i]`. In `END`, print `res[1]` through `res[NF]`, each as its own line. That is the transpose: old column `i` is the new row `i`.

Do not swap only the two sample header words and stop. Do not join with commas. Do not print by original rows. A 2-D array in another language is the same idea; the one-liner is this accumulation.

**Time:** O(rows times columns)  
**Space:** O(rows times columns) for the column strings

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

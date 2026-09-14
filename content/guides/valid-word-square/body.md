List `words` of 1 to 500 lowercase strings, each length 1 to 500. Return true if it is a word square: the k-th row and the k-th column read the same string. Rows need not all have the same length. `["abcd","bnrt","crmy","dtye"]` → true. `["abcd","bnrt","crm","dt"]` → true (jagged). `["ball","area","read","lady"]` → false because row 2 is `read` and column 2 is `lead`.

## Mirror cells; missing cell is false

Walk every character `words[i][j]`. If `j` is past the number of rows, or row `j` is shorter than `i+1` characters, or `words[j][i]` differs, return false. Otherwise the grid (including empty corners of a jagged layout) is a transpose of itself.

Word Squares (425) asks you to construct all squares from a dictionary. Valid Sudoku (36) checks 9-by-9 boxes. Transpose Matrix (867) always has a rectangular input.

Do not assume every row is as long as `words.length`. Do not skip the bounds check and crash. Do not only compare `words[i]` to a joined column without checking length first.

Time: O(n²)  
Space: O(1)

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

Screen `rows` by `cols` (each up to 2e4) and a sentence of at most 100 lowercase words (each length 1 to 10). Count how many times the sentence can be written, in order, wrapping to the next line when a word would not fit. Words do not split; consecutive words on a line have exactly one space. `["hello","world"]`, 2 rows, 8 cols → 1. `["a","bcd","e"]`, 3×6 → 2. `["i","had","apple","pie"]`, 4×5 → 1.

## Join once; each row is a cursor jump of cols

Build `s = words joined by spaces plus a trailing space`, length `m`. Imagine an infinite tape of `s`. `cur` starts at 0. For each row: add `cols`. If `s[cur % m]` is a space, the line ended on a separator — advance `cur` by 1 (that space is used). Else you landed inside a word: decrement `cur` until the previous character on the tape is a space (drop the unfinished word to the next line). After all rows, `cur / m` (integer) is how many full sentences fit.

Text Justification (68) pads spaces inside a line. Rearrange Spaces Between Words (1592) redistributes spaces, not a screen wrap.

Do not simulate every character of a 2e4 by 2e4 grid. Do not split a word across lines. Do not skip the trailing space in `s` — that space is the sentence boundary the modulo walk needs.

Time: O(rows times max word length)  
Space: O(total characters in the sentence)

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

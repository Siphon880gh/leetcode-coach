Print the 10th line of `file.txt`. Sample: a file whose tenth line is `Line 10` prints that line. If the file has fewer than 10 lines, print nothing.

## Address line 10; do not dump the rest

Transpose File rebuilds every column. Valid Phone Numbers filters by a regex. Word Frequency counts tokens. Here you only need one numbered line.

`sed -n 10p file.txt` is quiet (`-n`) except when `p` prints line 10. `awk 'NR==10'` is the same test on the record number. `head -n 10 | tail -n 1` also works if there are at least 10 lines; `sed`/`awk` stay quiet when the file is short.

Do not `cat` the whole file. Do not print line 1. Do not treat “10” as a search string inside a line. The note on the problem is that short files should not invent a tenth line.

**Time:** O(n) to reach line 10 (or EOF)  
**Space:** O(1) besides the current line

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

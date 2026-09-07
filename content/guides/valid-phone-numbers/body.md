Print the valid phone numbers from `file.txt` (one candidate per line, no leading or trailing spaces). Valid means exactly `ddd-ddd-dddd` or `(ddd) ddd-dddd` (digits; the second form has a space after the closing paren). Sample: `987-123-4567` and `(123) 456-7890` print; `123 456 7890` does not.

## Whole-line awk: hyphen form or paren form

Word Frequency tokenizes then counts. Combine Two Tables is SQL. Here each line is either keep or drop.

`awk` with a regex that is anchored at both ends. One branch is three digits, a hyphen, then the shared tail `ddd-dddd`. The other branch is `(ddd)` plus a space, then the same tail. `{3}` and `{4}` fix the lengths so you do not accept fewer or extra digits. The space-separated sample fails both branches.

Do not match a substring inside a longer line: drop `^` or `$` and junk around a valid core would slip through. Do not treat three space-separated groups as the hyphen form. `grep -E` with the same pattern is the same filter.

**Time:** O(n) over the file  
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

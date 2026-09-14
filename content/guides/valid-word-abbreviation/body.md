`word` is lowercase (length 1 to 20). `abbr` is letters and digits (length 1 to 10). Return whether `abbr` is a valid abbreviation: replaced runs are non-empty, not adjacent, and numbers have no leading zeros. `internationalization` / `i12iz4n` → true. `apple` / `a2e` → false.

## Two pointers plus a skip count

Pointers `i` on `word`, `j` on `abbr`, integer `x` (current skip). While both are in range: if `abbr[j]` is a digit, a `0` while `x` is still 0 is a leading zero → false; else fold the digit into `x` (`x` becomes `x×10` plus that digit). If it is a letter, advance `i` by `x`, reset `x` to 0, then `word[i]` must equal that letter (and `i` still in range) and step `i`. Always step `j`. After the loop, accept only when `i + x` equals the word length and `j` used the whole abbr (a trailing number still has to land exactly at the end).

Consecutive digits are one skip, so `s55n` is a 55-skip, not two adjacent replacements. `s0ubstitution` starts a number with 0. Generalized Abbreviation (320) asks you to list abbreviations; here you only check one pair. Valid Word Square (422) is a different grid check.

Do not treat `a2e` as matching `apple` (2 skips `pp`, leftover `le` vs `e`). Do not allow `s010n`. Do not ignore a leftover skip at the end of `abbr`.

Time: O(m + n)  
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

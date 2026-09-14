String `s` of length 1 to 1e5, letters from the English names of 0–9, guaranteed to be a valid mix. Return the digits those words encode, sorted ascending. `"owoztneoer"` → `"012"`. `"fviefuro"` → `"45"`.

## Unique letters pin the even digits; subtract for the odds

Count every character. Some letters belong to only one even word: `z` only in zero, `w` only in two, `u` only in four, `x` only in six, `g` only in eight. That gives counts of 0, 2, 4, 6, 8.

Then: `h` appears in three and eight, so threes = h-count minus eights. `f` appears in four and five. `s` appears in six and seven. Finally `o` is in 0, 1, 2, 4 so ones are leftover o. `i` is in 5, 6, 8, 9 so nines are leftover i. Emit digit `d` repeated `cnt[d]` times, in order 0 through 9.

Integer to English Words (273) goes the other way. Roman to Integer (13) maps a different numeral system. Do not search for whole words in the shuffled string.

Do not start with one or nine — those letters are shared. Do not sort the input letters as if they were digits. Do not leave leftover characters; the input is complete.

Time: O(n)  
Space: O(1) letter counts

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

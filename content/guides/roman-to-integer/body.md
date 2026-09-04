Roman digits are `I` 1, `V` 5, `X` 10, `L` 50, `C` 100, `D` 500, `M` 1000. Left to right they usually decrease. Six subtractive pairs flip the sign of the smaller digit: `IV` `IX` `XL` `XC` `CD` `CM`.

`MCMXCIV` → 1994 (`M` 1000, `CM` 900, `XC` 90, `IV` 4). Input is a valid numeral, length at most 15, value in `1..3999`.

## Look ahead one

Keep a map from character to value. Scan `s[0..n-2]`. If `value[s[i]] < value[s[i+1]]`, subtract `value[s[i]]`; otherwise add it. Always add the last character.

That one comparison covers every subtractive pair without a second table.

**Time:** O(n)  
**Space:** O(1) for a seven-entry map

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

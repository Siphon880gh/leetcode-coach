String `s` (length 1..3e5, printable ASCII). Reverse only the vowels and return the new string. Vowels are `a e i o u` in both cases. `IceCreAm` → `AceCreIm` (vowels `I,e,e,A` become `A,e,e,I`). `leetcode` → `leotcede`. `y` is not a vowel.

## Walk inward; swap only when both pointers sit on vowels

Turn `s` into a char array. `i = 0`, `j = n − 1`. While `i < j`: advance `i` while it is not a vowel; retreat `j` while it is not a vowel; if `i < j`, swap, then `i += 1`, `j −= 1`. Consonants stay put. Case is preserved (`A` is still `A` after the swap).

A set or a 128-slot bool table for `aeiouAEIOU` is O(1) per check. Do not reverse the whole string (344). Do not reverse words (151). Do not treat `y` as a vowel.

Time: O(n)  
Space: O(n) for the char array (immutable strings), or O(1) extra besides that

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

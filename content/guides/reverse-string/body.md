Character array `s` (length 1..1e5, printable ASCII). Reverse it in place with O(1) extra memory. `["h","e","l","l","o"]` → `["o","l","l","e","h"]`. `Hannah` → `hannaH`. Return nothing; mutate `s`.

## Swap from both ends until the pointers meet

`i = 0`, `j = n − 1`. While `i < j`, swap `s[i]` with `s[j]`, then `i += 1`, `j −= 1`. Odd length: the middle character stays. Even length: every pair swaps.

This is O(n) time and O(1) extra. A new reversed array (or `s[::-1]` assigned back as a copy) violates the extra-memory rule. Reverse Words in a String (151) reverses tokens, not the raw character array. Reverse String II (541) reverses every block of `2k`. Reverse Vowels (345) only swaps vowels.

Do not allocate O(n) storage. Do not reverse words. Do not return a new string and leave `s` unchanged.

Time: O(n)  
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

String `s` of English letters, length 1 to 2000, mixed case. Return the length of the longest palindrome you can build by rearranging those letters. `A` and `a` are different. `abccccdd` → 7 (`dccaccd`). `a` → 1.

## Even counts in pairs; at most one odd in the middle

Count each character (`Counter` or 128 slots). For every count `v`, add the largest even number that does not exceed `v` (pairs of that letter). If the running total is still less than `n`, at least one letter had an odd leftover — add 1 for the center.

Equivalent: keep a parity flag per letter; the answer is `n` minus leftover odds plus 1 if any odd remains (one odd can sit in the middle).

Longest Palindromic Substring (5) needs a contiguous slice; here you may reorder. Valid Palindrome (125) checks an existing string after skipping non-letters. Palindrome Partitioning (131) splits `s`; it does not rebuild a new palindrome from a bag of letters.

Do not treat `Aa` as a palindrome. Do not leave more than one unpaired letter in the middle. Do not return the palindrome string — only its length.

Time: O(n)  
Space: O(1) 128 slots

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

True if digit string `num` looks the same after a 180° rotation (upside down). Length 1..50, digits only, no leading zeros except `"0"`. `"69"` and `"88"` → true. `"962"` → false.

## Map each digit, then two pointers

Palindrome Number (9) asks the same characters forward and back. Here the **pair** is a rotation, not equality: 0↔0, 1↔1, 8↔8, 6↔9, 9↔6. 2, 3, 4, 5, 7 have no valid rotate (treat as −1). Strobogrammatic Number II **generates** all such numbers of length n.

Array `d[0..9]`: rotate of that digit, or −1. `i = 0`, `j = n−1`. While `i ≤ j`: if `d[num[i]]` is not equal to `num[j]`, false. Then `i` plus one, `j` minus one. Odd length: the middle must map to itself (so only 0, 1, 8). `"69"`: rotate of 6 is 9, matches the other end. `"6"` alone fails because 6 rotates to 9, not 6.

Do not require `num[i] == num[j]`. Do not allow 2 as a “maybe 5”. Do not skip the middle on odd length.

**Time:** O(n)  
**Space:** O(1)

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

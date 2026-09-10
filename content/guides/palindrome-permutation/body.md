True if some permutation of `s` is a palindrome. Lowercase English, length up to 5000. `"code"` → false. `"aab"` → true (`aba`). `"carerac"` → true (`racecar`).

## Count letters; at most one odd

Valid Anagram compares two strings’ bags. Palindrome Linked List walks a list. Palindrome Permutation II **generates** every palindromic permutation. Here you only ask whether one exists.

A palindrome pairs letters from the outside in. Every letter except a possible center must appear an even number of times. Count 26 (or a map). Sum `count AND 1` (the odd bits). Return whether that sum is less than 2. `"aab"`: a even, b odd. `"code"`: four odds. Bit twin: XOR a 26-bit mask (flip bit `c − 'a'`); at most one bit remains set (`mask AND (mask minus 1) == 0`).

Do not generate permutations. Do not require the string to already be a palindrome (`"aab"` is not). Do not allow two odd counts even if the length is even.

**Time:** O(n)  
**Space:** O(1) for 26 letters

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

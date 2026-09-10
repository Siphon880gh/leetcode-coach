Return every palindromic permutation of `s`, no duplicates, any order. Empty list if none exist. Length at most 16, lowercase. `"aabb"` → `["abba","baab"]`. `"abc"` → `[]`.

## Center from the odd letter; wrap pairs

Palindrome Permutation (266) only asks whether one exists (at most one odd count). Permutations of a string then a palindrome check would emit duplicates and explode. Strobogrammatic Number II wraps rotate-pairs; here you wrap **the same** letter on both ends.

Count 26. If two or more odds, return `[]`. If one odd, that letter is the seed `mid` (and consume one from the count). Even length: seed is the empty string. `dfs(t)`: if `len(t) == n`, keep `t`. Else for each letter still holding at least 2 leftover, subtract 2, recurse `c + t + c`, add 2 back. Growing from the middle uses each pair once, so `"aabb"` yields `abba` and `baab` without listing `baba` as a separate scramble of a non-palindrome.

Do not permute all n! strings. Do not wrap a letter on one side only. Do not skip the two-odd reject (`"abc"`).

**Time:** O(n · k) to copy k palindromes (k is the number of distinct half-permutations)  
**Space:** O(n) recursion plus the answer

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

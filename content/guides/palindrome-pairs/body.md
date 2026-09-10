Unique strings `words`. Return every `(i, j)` with `i ≠ j` such that `words[i]` concatenated with `words[j]` is a palindrome. `["abcd","dcba","lls","s","sssll"]` → `[[0,1],[1,0],[3,2],[2,4]]`. `["bat","tab","cat"]` → `[[0,1],[1,0]]`. `["a",""]` → `[[0,1],[1,0]]` (the empty word pairs with a palindrome). Up to 5000 words, each length at most 300.

## Hash the word; only the leftover must be a palindrome

Checking every ordered pair is too slow (n² concatenations). Map each string to its index (words are unique). For each `w` at index `i`, try every cut `j` so `a = w[:j]` and `b = w[j:]`:

1. If `b` is a palindrome and `reverse(a)` is another word `k`, then `w + reverse(a)` is a palindrome → `[i, k]`.
2. If `j > 0`, `a` is a palindrome, and `reverse(b)` is another word `k`, then `reverse(b) + w` is a palindrome → `[k, i]`.

The `j > 0` skip: the empty-prefix case would rediscover reverse-of-whole pairs that the empty-suffix case already listed. Empty `b` is a palindrome, so a word and its reverse still produce both orders. The empty string is in the map like any other word.

A reversed trie is the same split idea without hashing whole strings. Doocs Solution 1 is the map.

Do not concatenate every pair. Do not treat this as “all palindromic substrings” (5 / 647). Do not allow `i == j`.

Time: O(n L²) under the given limits (L cuts, palindrome check of a leftover)  
Space: O(n L) for the map

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

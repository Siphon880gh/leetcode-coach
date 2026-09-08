True if `t` is an anagram of `s` (same letters, same multiplicities, any order). Lowercase English. Length up to `5 × 10⁴`. `"anagram"` / `"nagaram"` → true. `"rat"` / `"car"` → false.

## Count 26, or sort both

Group Anagrams (49) buckets many words. Ransom Note / Valid Palindrome are different predicates. Here you only compare two strings.

If `len(s) ≠ len(t)`, false immediately. Count letters in `s` (array of 26, or a map). For each character in `t`, decrement; if a count goes below 0, false. After the scan, all zeros (the length check already guarantees you cannot have leftovers). `Counter(s) == Counter(t)` is the same idea. Sorting both and comparing the strings is O(n log n) and also correct.

Unicode follow-up: swap the size-26 array for a hash map of code points. Do not use `s == t`. Do not treat `"ab"` and `"aab"` as anagrams. Do not return the grouped lists from 49.

**Time:** O(n) counting; O(n log n) sort  
**Space:** O(1) for 26 letters (or O(σ) for Unicode)

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

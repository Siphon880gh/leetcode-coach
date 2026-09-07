Group strings that are anagrams of each other. Order of groups and order inside a group do not matter. Lowercase letters only. n ≤ 10⁴, each string length ≤ 100.

`["eat","tea","tan","ate","nat","bat"]` → `[["bat"],["nat","tan"],["ate","eat","tea"]]`.

## Sorted letters as the key

Two words are anagrams iff they have the same letter multiset. Sorting a word is a canonical fingerprint: `"eat"`, `"tea"`, `"ate"` all become `"aet"`.

Walk `strs`. For each `s`, `key = sorted(s)` (join the sorted chars). Append `s` to `map[key]`. Return the map’s value lists.

A 26-count tuple (or `"#".join(counts)`) is the same key without an O(k log k) sort — useful when k is large. Pairwise compare every pair is O(n²) and fails the size.

**Time:** O(n × k log k) with a sort key; O(n × k) with a count key  
**Space:** O(n × k) to store the groups

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

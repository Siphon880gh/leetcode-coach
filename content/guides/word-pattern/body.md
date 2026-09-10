`pattern` of lowercase letters and string `s` of words separated by single spaces (no leading/trailing space). True iff there is a **bijection**: each letter maps to exactly one non-empty word, and each word maps to exactly one letter. `"abba"` / `"dog cat cat dog"` → true. `"abba"` / `"dog cat cat fish"` → false. `"aaaa"` / `"dog cat cat dog"` → false. Pattern up to 300, `s` up to 3000.

## Split, then two maps like Isomorphic Strings

Isomorphic Strings (205) bijection is letter-to-letter. Word Pattern II searches a split of `s` with no spaces given. Here the split is already by spaces.

`ws = s.split()`. If `len(pattern) != len(ws)`, false. Walk `a, b` in lockstep. `d1` maps letter → word, `d2` maps word → letter. If `a` is already mapped and not to `b`, false. If `b` is already mapped and not to `a`, false (the `"abba"` / `"dog dog dog dog"` trap: `a` and `b` cannot share `"dog"`). Else store both. Finish → true.

One map only lets two letters share a word. Skipping the length check can zip a short pattern against leftover words. Do not treat this as Group Anagrams (bag of letters) or as identity (`pattern` need not equal the words).

**Time:** O(m + n) for pattern length m and string length n  
**Space:** O(m + n) for the maps and the split

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

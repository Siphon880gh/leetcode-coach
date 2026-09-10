String `s` of lowercase letters, length 1..1e5. Return the index of the first character that appears exactly once. If every letter repeats, return `−1`. `leetcode` → 0 (`l`). `loveleetcode` → 2 (`v`). `aabb` → `−1`.

## Frequency array, then a left-to-right pass

Count every character (`Counter` or 26 slots). Walk `s` from the left and return the first `i` with `cnt[s[i]] == 1`. If none, `−1`.

A queue of candidate indices (drop when a letter’s count hits 2) also finds the earliest unique, still linear. Two pointers that skip duplicates without a full count miss letters that appear later.

Single Number (136) is XOR on ints, not the first unique letter. First Unique Number (1429) is a stream with `add` / `showFirstUnique` — same count idea, different API.

Do not return the character instead of its index. Do not scan the rest of `s` from every `i` (`O(n²)` at 1e5). Do not pick the last unique index.

Time: O(n)  
Space: O(26)

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

String `s` (lowercase, length up to `1e4`) and integer `k` (up to `1e5`). Return the length of the longest substring in which every character appears at least `k` times, or `0` if none. `"aaabb"`, `k = 3` → `3` (`"aaa"`). `"ababbc"`, `k = 2` → `5` (`"ababb"`). If `k` is larger than `len(s)`, the answer is `0`. If `k = 1`, the whole string works.

## Rare letters are walls

Count letters on the current closed range `[l, r]`. If every letter that appears has count at least `k`, the whole range is valid — return `r − l + 1`. Otherwise pick one letter whose count is positive but below `k`. It cannot sit in any valid substring of this range, so split the range on every run of that letter and recurse on the leftover pieces. Take the max.

Each character is counted once per recursion level, and there are at most 26 distinct letters, so the work stays O(26 n).

A sliding-window alternative enumerates how many distinct letters `t` you allow (`1..26`) and finds the longest window with exactly `t` distinct letters where every letter in the window already has frequency at least `k`.

Longest Substring with At Most K Distinct (340) caps how many different letters, not how often each repeats. Longest Substring Without Repeating Characters (3) wants uniqueness, the opposite of “at least k copies.”

Do not return the whole string just because some letter hits `k`. Do not skip splitting when a rare letter sits in the middle. Do not use a global count and ignore that a substring can drop a rare letter.

Time: O(26 n)  
Space: O(n) recursion plus 26 counts

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

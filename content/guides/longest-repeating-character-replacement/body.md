Uppercase string `s`, length 1 to 1e5, and integer `k` in 0..n. You may change at most `k` letters (each to any other uppercase). Return the longest substring you can make all one letter. `"ABAB"`, k=2 → 4. `"AABABBA"`, k=1 → 4 (`BBBB` after one change).

## Window is legal while (length − majority) ≤ k

Grow a right pointer. Count letters in `[l, r]`. Let `mx` be the highest count of any one letter in that window. The other `r − l + 1 − mx` letters must be replaced. If that exceeds `k`, slide `l` forward one. You can keep a historical `mx` that never decreases: a slightly stale majority only shrinks earlier, and we only care about the maximum legal width, which is `n − l` at the end.

Longest Substring Without Repeating Characters (3) wants uniqueness. Longest Substring with At Most K Distinct (340) caps how many different letters, not how many replacements. 395 splits on letters that appear fewer than k times.

Do not force the majority letter to be the first character. Do not shrink by more than one when one shrink already restores the invariant (the window only grows). Do not treat `k=0` as the whole string unless it is already one letter.

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

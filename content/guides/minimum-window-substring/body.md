Return the shortest substring of `s` that covers every character of `t`, including duplicates. If none exists, return `""`. Lengths up to 10^5.

`s = "ADOBECODEBANC"`, `t = "ABC"` → `"BANC"`. `s = "a"`, `t = "aa"` → `""`.

## Cover t, then shrink

This is not Longest Substring Without Repeating Characters (a max unique window) and not Substring with Concatenation of All Words (fixed word hops). Extra unused letters are allowed; `t` may repeat letters.

Count `t` in `need`. Expand `r` and increment `window`. If `need[c] >= window[c]`, that copy was still required, so `cnt++`. While `cnt == len(t)`, the window covers `t`: record `mi = r - l + 1` and `k = l` when shorter, then drop `s[l]`. If `need[s[l]] >= window[s[l]]` before the decrement, `cnt--`. The first cover (`"ADOBEC"`) is not the answer.

If `k` stays `-1`, return `""`. Else return the contiguous slice `s[k:k+mi]`, not a subsequence.

**Time:** O(m + n)  
**Space:** O(|Σ|) (128 letters)

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

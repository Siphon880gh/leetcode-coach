Return true if `s` can be split into one or more dictionary words. Reuse is allowed. `n` up to 300.

`leetcode` with `[leet, code]` → true. `applepenapple` with `[apple, pen]` → true. `catsandog` with `[cats, dog, sand, and, cat]` → false.

## Prefix DP, not greedy longest

This is a boolean, not Word Break II’s list of sentences. Word Ladder changes letters. Greedy longest match can eat `cat` then `sand` and get stuck even when another split might work. You may skip unused dict words. Decode Ways uses digit rules and a count of ways. Palindrome Partitioning lists palindrome cuts, not a boolean cover.

Put the dictionary in a set. `f[0] = true` — the empty prefix is already segmented so a dict word matching `s[0:i]` can start the string. The dictionary does not need to contain the empty string. For `i` from 1 to `n`, `f[i]` is true if some `j < i` has `f[j]` and `s[j:i]` in the set. Return `f[n]`, not the list of splits and not a count of ways.

`leetcode`: `f` at 4 and 8 become true. `catsandog` never reaches `n`. Reuse is free because a word can match many slices.

**Time:** O(n²) substring checks  
**Space:** O(n)

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

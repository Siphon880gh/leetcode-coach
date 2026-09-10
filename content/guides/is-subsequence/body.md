Given `s` and `t` (lowercase), return true if `s` is a subsequence of `t`: keep relative order, deletions allowed. `"abc"` / `"ahbgdc"` → true. `"axc"` / `"ahbgdc"` → false. `"ace"` is a subsequence of `"abcde"`; `"aec"` is not (order broke). `s` length up to 100, `t` up to `1e4`. Empty `s` is true.

## Greedy two pointers

Pointer `i` on `s`, `j` on `t`. Walk `t`. When `s[i] == t[j]`, advance `i`. Always advance `j`. If `i` reaches `len(s)` before `t` runs out (or exactly when both end), every letter of `s` found in order.

You never skip a match: the leftmost unused copy in `t` is always as good as a later one for a single query. Substring would require a contiguous block. Longest Common Subsequence (1143) asks for a longest shared subsequence of two strings, not a yes/no for a given `s`.

Follow-up: many `s` against one `t`. Precompute index lists per letter in `t`, then for each `s` binary-search the next index strictly after the last pick (Number of Matching Subsequences, 792). Do not restart a full scan of `t` for every `s` when k is huge.

Do not require contiguous matches. Do not reverse `s`. Do not treat `"aec"` as true for `"abcde"`.

Time: O(n) one scan of `t` (and `s`)  
Space: O(1)

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

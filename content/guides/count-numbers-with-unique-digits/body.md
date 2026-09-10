Given `n` (0..8), count integers `x` with all distinct digits where `0 ≤ x < 10^n`. `n = 2` → 91 (0..99 except 11, 22, …, 99). `n = 0` → 1.

## Add permutations for each length

Include 0 as the one 0-digit / `n = 0` answer. Length 1 contributes 10. For length `k` from 2 to `n`, the first digit has 9 choices (1..9), then 9, 8, … leftover digits: `9 × 9 × 8 × … × (11 − k)`. Sum those layers.

Digit DP (doocs Solution 1) walks positions from the high end with a 10-bit used mask and a `lead` flag. Leading zeros do not mark a digit used, so shorter numbers are counted in the same search. `dfs(n−1, 0, true)` is the answer; `n = 0` hits the base case immediately.

Do not loop up to `10^n`. Do not treat `n = 0` as 0. Do not let a non-leading digit reuse a bit already in the mask.

Time: O(1) combinatorics (`n ≤ 8`); digit DP about `n × 1024 × 10`  
Space: O(1) combinatorics; memo about `n × 1024`

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

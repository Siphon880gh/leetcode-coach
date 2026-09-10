Integer `n`. Return an array of length `n + 1` where `ans[i]` is the number of 1-bits in `i` (`0 ≤ i ≤ n`). `n = 2` → `[0,1,1]`. `n = 5` → `[0,1,1,2,1,2]`. `n` up to 1e5. Do not call a language popcount helper.

## Drop the lowest 1; that prefix is already in the array

Number of 1 Bits (191) clears one set bit with `i AND (i − 1)`. Here every smaller value is already filled, so one addition is enough:

`ans[0] = 0`. For `i` from 1 through `n`: `ans[i] = ans[i AND (i − 1)] + 1`.

Twin recurrence: `ans[i] = ans[i shifted right 1] + (i AND 1)` (the high bits of `i` are `i / 2`, plus the last bit). Both are one pass, O(n).

A per-index 191 loop is O(n log n) and is the easy follow-up, not the linear pass. Doocs Solution 1 uses `bit_count` / `__builtin_popcount`; Solution 2 is the DP above.

Do not skip `ans[0]`. Do not treat this as counting bits of `n` alone (191). Do not rely on a built-in popcount.

Time: O(n)  
Space: O(n) for the answer array

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

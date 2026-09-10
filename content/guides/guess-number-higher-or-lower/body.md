I pick an integer in `1 .. n` (n up to `2³¹ − 1`). You guess it by calling `guess(num)`, which returns `−1` if `num` is higher than the pick, `1` if `num` is lower, and `0` if equal. Return the pick. `n = 10`, pick `6` → `6`. `n = 1`, pick `1` → `1`. `n = 2`, pick `1` → `1`.

## Lower bound: first x with guess(x) ≤ 0

`guess(x)` is positive while `x` is still below the pick, then non-positive from the pick onward. So the answer is the leftmost x where `guess(x) ≤ 0`.

`l = 1`, `r = n`. While `l < r`: `mid = (l + r) >>> 1` (or `l + ((r − l) >> 1)`) so `l + r` cannot overflow a 32-bit signed int. If `guess(mid) ≤ 0`, the pick is in `[l, mid]` → `r = mid`. Else it is in `[mid + 1, r]` → `l = mid + 1`. When the loop ends, `l` is the pick. `n = 1` never enters the loop and returns 1.

First Bad Version (278) uses a boolean `isBadVersion` on a monotone prefix of good versions. Guess Number Higher or Lower II (375) is a minmax DP on the worst-case cost of a guessing strategy. Linear scan from 1 to n is too many API calls.

Do not flip the API signs (`−1` means your guess was too high). Do not set `r = mid − 1` on `guess(mid) ≤ 0` (you might skip the pick). Do not use signed `(l + r) / 2` when `n` is `2³¹ − 1`.

Time: O(log n) API calls
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

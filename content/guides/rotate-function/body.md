Integer array `nums` of length `n` (up to `1e5`). Clockwise rotate by `k` to get `arr_k`. `F(k)` is `0 × arr_k[0] + 1 × arr_k[1] + … + (n−1) × arr_k[n−1]`. Return the max of `F(0) .. F(n−1)`. `[4,3,2,6]` → `26` (`F(3)`). `[100]` → `0`. The answer fits in a 32-bit int.

## Recurrence, not n full weighted sums

A clockwise step moves the last element to index 0 (coefficient 0) and adds 1 to every other coefficient. So if `s` is `sum(nums)` and `v` is the value that just became the new head, `F(k+1) = F(k) + s − n × v`. From the original array, after `i` clockwise steps that new head is `nums[n − i]`.

Compute `F(0)` in one pass (`sum of i × nums[i]`), then walk `i = 1 .. n−1` updating `F` and tracking the max. That is O(n). Building each rotated array and scoring it is O(n²) and will not finish at `n = 1e5`.

Rotate Array (189) mutates the array in place; here you never need the rotated copy. Do not treat coefficients as 1-based.

Do not forget `v` is the original last-of-the-current-rotation (`nums[n − i]`), not `nums[i]`. Do not skip adding `s` (every surviving coefficient went up by 1). A single-element array is `0`.

Time: O(n)  
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

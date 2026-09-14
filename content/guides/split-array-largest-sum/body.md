Array `nums` (length 1 to 1000, values 0 to 1e6) and integer `k` (1 to min(50, n)). Split `nums` into exactly `k` non-empty contiguous subarrays so the largest subarray sum is as small as possible. Return that minimized largest sum. `[7,2,5,10,8]`, `k = 2` → `18` (`[7,2,5]` and `[10,8]`). `[1,2,3,4,5]`, `k = 2` → `9`.

## Binary search the cap; greedy count of pieces

A larger allowed piece-sum never needs more pieces, so search the cap. Low bound: `max(nums)` (one element cannot be split). High bound: `sum(nums)` (one piece). For `mid`, walk left to right and start a new piece whenever adding `x` would exceed `mid`. If the number of pieces is at most `k`, try a smaller cap; else raise the low bound.

Capacity to Ship Packages Within D Days (1011) is the same search: days instead of `k`, weights instead of `nums`. Maximum Subarray (53) maximizes one contiguous sum (Kadane); here you minimize the worst of `k` pieces. Partition to K Equal Sum Subsets (698) is not contiguous.

Do not pick non-contiguous groups. Do not set the low bound to 0 when some `nums[i]` is larger than that cap. Do not treat `k = 1` as anything other than the full sum.

Time: O(n log S) S = sum of nums  
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

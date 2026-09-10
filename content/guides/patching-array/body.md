Sorted positive array `nums` and integer `n`. Add as few extra numbers as possible so every integer in `[1, n]` is a subset sum of the patched array. `[1,3]`, `n = 6` → 1 (patch `2`). `[1,5,10]`, `n = 20` → 2. `[1,2,2]`, `n = 5` → 0. `n` can be `2³¹ − 1`.

## Covered prefix `[1, x−1]`; greedy patch is `x`

Let `x` be the smallest positive integer you still cannot form. Then `[1, x−1]` is fully covered (empty when `x = 1`). To cover `x` you must add a value at most `x`. Adding exactly `x` is best: the new uncovered start becomes `2x`. Adding a smaller `x'` only reaches `x + x'`, which is worse than doubling.

Walk `i` through `nums` while `x ≤ n` (64-bit `x`): if `nums[i] ≤ x`, consume it (`x += nums[i]`, `i += 1`); else patch (`ans += 1`, double `x`). Stop when `x` exceeds `n`. Time is O(m + log n) because each patch at least doubles `x`.

Do not treat this as Coin Change (322) with unlimited copies. Do not patch a value larger than `x` (it leaves a hole). Do not overflow 32-bit when doubling `x`.

Time: O(m + log n)  
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

Two digit arrays `nums1`, `nums2` (length up to 500) and `k`. Build the **largest** length-`k` number by picking digits from both, keeping relative order **inside** each array. `[3,4,6,5]` and `[9,1,2,5,8,3]`, `k = 5` → `[9,8,6,5,3]`. `[6,7]` and `[6,0,4]`, `k = 5` → `[6,7,6,0,4]`. `k` is at most `m + n`.

## Split, drop with a stack, merge by leftover suffix

This is not Remove K Digits (402) on a concatenation. You choose how many digits come from each array: `x` from `nums1` and `k − x` from `nums2`, with `x` in `[max(0, k − n), min(k, m)]`.

`f(nums, t)` is the max subsequence of length `t`: monotonic stack, drop a smaller top while you still have drops left (`remain = n − t`). Then **merge** the two subsequences like largest-merge, not like merging sorted arrays. If the current digits tie, compare the **rest of each sequence** and take from the lexicographically larger remaining suffix (`[6,7]` vs `[6,0,4]` must pick the first `6` so `7` can follow). Keep the best among all splits.

Do not merge by only the current digit. Do not shuffle order inside one array. Do not skip the empty-side split (`x = 0` when `k ≤ n`).

**Time:** O(k² (m + n))  
**Space:** O(k)

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

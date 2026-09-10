Two integer arrays `nums1` and `nums2`, each sorted non-decreasing, lengths up to 1e5, and an integer `k` up to 1e4. A pair is one value from each array. Return `k` pairs with the smallest sums (any order among ties is fine if the sums match the smallest). `[1,7,11]` and `[2,4,6]`, `k = 3` → `[[1,2],[1,4],[1,6]]`. Duplicate values count as distinct pairs: `[1,1,2]` and `[1,2,3]`, `k = 2` → two copies of `[1,1]`.

`k` is at most the product of the two lengths, so a full answer always exists. Building every pair then sorting is the product of the lengths — too big.

## Min-heap of the frontier: next unused column per row

Think of a virtual matrix `M[i][j] = nums1[i] + nums2[j]`. Each row is sorted (because `nums2` is). Each column is sorted (because `nums1` is). You only need the `k` smallest cells.

Like Merge k Sorted Lists, keep a min-heap of the current head of each row you still care about. Seed at most `k` rows: for each `i` from 0 through `min(k, len(nums1)) − 1`, push `(nums1[i] + nums2[0], i, 0)`. Then `k` times: pop the smallest `(sum, i, j)`, emit `[nums1[i], nums2[j]]`, and if `j + 1` is still in `nums2`, push `(nums1[i] + nums2[j + 1], i, j + 1)`.

You never enqueue `(i, j)` unless `(i, j − 1)` already left the heap (or `j` is 0), so you do not need a visited set.

Merge k Sorted Lists (23) splices list nodes. Kth Smallest in a Sorted Matrix (378) is the same heap idea on a real matrix. Kth Largest Element (215) ranks one array, not pairs.

Do not generate all `n × m` pairs. Do not seed every row of `nums1` when `k` is tiny and `nums1` is huge — cap the seed at `k`. Do not skip pushing the next column after a pop; that truncates a cheap row like the `1` row in the first example.

Time: O(k log k) heap ops (heap size at most k)
Space: O(k)

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

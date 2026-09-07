`nums1` has `m` values then `n` zeros; `nums2` has `n` values. Merge into `nums1` in non-decreasing order. Void. `m + n` ≤ 200.

`[1,2,3,0,0,0]` and `[2,5,6]` → `[1,2,2,3,5,6]`. `m = 0`: only `nums2` is copied in. `n = 0`: the loop never runs.

## Fill from the back

This is arrays with a spare tail in `nums1`, not Merge Two Sorted Lists. Copy-then-sort is extra time. Writing from the front overwrites a `nums1` value you still need. The zeros at the end are the safe write zone.

`i = m - 1`, `j = n - 1`, `k = m + n - 1`. While `j ≥ 0`: if `i ≥ 0` and `nums1[i] > nums2[j]`, copy `nums1[i]` and step `i`; else copy `nums2[j]` and step `j`. Then `k -= 1`. When `nums2` is exhausted, leftover `nums1` values already sit in the right places. Return nothing — mutate `nums1`. Not Merge Intervals, not Merge k Sorted Lists.

**Time:** O(m + n)  
**Space:** O(1)

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

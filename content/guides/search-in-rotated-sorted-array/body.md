`nums` was strictly increasing, then left-rotated at some unknown `k`. Values are unique. Return the index of `target`, or `-1`. Must be O(log n). n ≤ 5000.

`[4,5,6,7,0,1,2]`, target `0` → 4. Same array, target `3` → `-1`. `[1]`, target `0` → `-1`.

## Sorted half first

A normal binary search dies because the whole range is not monotone. After a rotation, **one** of the two halves `[lo, mid]` or `[mid, hi]` is still sorted. Decide which, then ask whether `target` lives in that sorted run.

While `lo < hi`:

- `mid = (lo + hi) // 2`
- If `nums[0] <= nums[mid]`, the left piece through `mid` is sorted.
  - If `nums[0] <= target <= nums[mid]`, set `hi = mid`.
  - Else the target is past the cut: `lo = mid + 1`.
- Otherwise the right piece after `mid` is sorted.
  - If `nums[mid] < target <= nums[n-1]`, set `lo = mid + 1`.
  - Else `hi = mid`.

When the loop ends, `lo == hi`. Return `lo` if `nums[lo] == target`, else `-1`.

You never hunt for `k` first. Comparing `nums[0]` to `nums[mid]` tells you which side of the rotation you are on.

**Time:** O(log n)  
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

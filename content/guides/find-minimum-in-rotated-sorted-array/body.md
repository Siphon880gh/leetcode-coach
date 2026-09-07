Unique ascending array rotated 1..n times; return the minimum in O(log n). `[3,4,5,1,2]` → 1. `[4,5,6,7,0,1,2]` → 0. `[11,13,15,17]` → 11. `n` ≤ 5000.

## Binary search vs the last value

`min()` is O(n). Search in Rotated Sorted Array finds a target index. Rotated II allows duplicates. Product subarray is DP. The min is not always 0. Sorting costs extra and is not O(log n). You only need the rotation’s valley.

`l, r = 0, n-1`. While `l < r`: `mid = (l+r)//2`. If `nums[mid] > nums[-1]`, `l = mid+1`; else `r = mid`. Return `nums[l]`. When `nums[mid] <= last`, `mid` itself can be the minimum; dropping it would skip the answer. Else includes equality so a fully rotated-n array (already sorted) keeps shrinking `r` toward 0.

Values are unique, so you do not need Rotated II’s shrink-when-equal. `[11,13,15,17]` never has `mid > last`, so `l` stays 0. `[3,4,5,1,2]` returns 1 — the valley after 5.

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

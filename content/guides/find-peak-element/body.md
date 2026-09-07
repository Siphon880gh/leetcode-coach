Return any peak index. A peak is strictly greater than its neighbors; imagine `nums[-1]` and `nums[n]` are −∞. Neighbors never equal. Must be O(log n). `[1,2,3,1]` → 2. `[1,2,1,3,5,6,4]` may return 1 or 5. Length up to 1000.

## Binary search on the slope vs the right neighbor

A linear scan is O(n). Find Min in Rotated Sorted Array compares mid to the last value and returns a min, not a peak. One Edit is strings. There is no target: any peak is fine. Compare neighbors, not a search key.

`left = 0`, `right = n-1`. While `left < right`: `mid = (left+right) >> 1`. If `nums[mid] > nums[mid+1]`, `right = mid` (mid can be the peak). Else `left = mid+1`. Return `left`.

On `[1,2,3,1]`, mid is 1, `nums[1]=2` vs `nums[2]=3`. Climbing, so `left = mid+1 = 2`. Next mid is 2, `3 > 1` so `right = 2`. Return index 2, not the value 3. When mid is climbing you must move left up, not shrink right onto mid.

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

`nums` is sorted and unique inside `[lower, upper]`. Return the shortest list of inclusive ranges that cover every missing integer. `[0,1,3,50,75]`, 0..99 → `[[2,2],[4,49],[51,74],[76,99]]`. `[-1]` with bounds −1..−1 → `[]`. At most 100 values.

## Prefix hole, pairwise holes, suffix hole

You are listing absences, not merging overlaps and not describing the values already in `nums`. Find Peak is binary search on a slope.

Empty `nums` → `[[lower, upper]]`. If `nums[0] > lower`, emit `[lower, nums[0]-1]`. Pairwise emit `[a+1, b-1]` when `b - a > 1`. If `nums[-1] < upper`, emit `[nums[-1]+1, upper]`. Consecutive values (`b - a == 1`) emit nothing. A single missing integer is `[x, x]`, not skipped.

On `[0,1,3,50,75]` with 0..99, the first emitted range is `[2,2]` — 0 and 1 sit at the start, then 2 is missing before 3. Then `[4,49]`, `[51,74]`, and `[76,99]`. Do not dump the whole `[0,99]`. `[-1]` with `lower = upper = -1` has no missing numbers, so `[]`. Covering the whole interval would include `nums`.

**Time:** O(n)  
**Space:** O(1) extra besides the answer

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

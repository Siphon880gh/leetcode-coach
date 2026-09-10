Stream of non-negative integers. After each `addNum`, the set of values seen so far should be summarized as sorted disjoint closed intervals. `getIntervals` returns that list. Example: 1, then 3, then 7, then 2 (merges to `[1, 3]`), then 6 (touches 7) → `[[1, 3], [6, 7]]`. Values up to 10^4; about 3×10^4 mixed calls, but at most 100 `getIntervals`.

## Floor, ceiling, then one of four cases

Keep an ordered map from interval start to `[start, end]`. For `val`, look at the interval with the greatest start ≤ `val` (floor) and the least start ≥ `val` (ceiling).

- Already inside floor (`val` ≤ floor’s end): ignore.
- Floor ends at `val−1` and ceiling starts at `val+1`: stretch floor’s end to ceiling’s end and delete ceiling.
- Only floor is adjacent or overlapping: raise floor’s end.
- Only ceiling is adjacent: rekey it so the start becomes `min(val, old start)` (or mutate the stored start if you return values, not keys).
- Else insert `[val, val]`.

Because there are few disjoint runs compared with the stream, a TreeMap of intervals is enough. Do not rebuild Merge Intervals over every number on each `getIntervals`. Do not leave overlapping ranges. Duplicates must not split a range.

Time: O(log k) per add, O(k) to dump intervals (k = number of runs)  
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

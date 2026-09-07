`intervals` is already sorted by start and pairwise non-overlapping. Insert `newInterval` and merge any ranges that share a point. n ≤ 10⁴.

`[[1,3],[6,9]]` plus `[2,5]` → `[[1,5],[6,9]]`. `[[1,2],[3,5],[6,7],[8,10],[12,16]]` plus `[4,8]` → `[[1,2],[3,10],[12,16]]`. Empty list → just the new range.

## Append, then merge like 56

A binary-search splice by start leaves overlaps: `[1,3]` and `[2,5]` would sit as two items. Merge Intervals on the original list alone drops `newInterval`.

The writeup is blunt: push `newInterval` onto the list, sort by start (the append broke sorted order), then the same one-pass merge as problem 56 — flush when the last end is strictly less than the next start, else grow the last end. `[4,8]` can eat several middle ranges, not only the tail, so “merge last two after append” is wrong.

A linear scan that copies ranges wholly left of the new one, merges the overlap window, then copies the rest is O(n) and also correct; the taught version pays O(n log n) to reuse the 56 helper.

**Time:** O(n log n)  
**Space:** O(n) for the new list

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

Given `intervals[i] = [start, end]`, return whether one person can attend **all** of them. Two meetings that meet at the same instant (`end = t` and next `start = t`) do **not** overlap. `[[0,30],[5,10],[15,20]]` → false. `[[7,10],[2,4]]` → true. Length 0..10⁴. Empty → true.

## Sort, then only check neighbors

Merge Intervals (56) **unions** overlapping ranges. Meeting Rooms II (253) asks how many rooms you need (max concurrent). Here you only need a yes/no: any overlap at all?

Sort by start. Walk consecutive pairs: if `prev.end > next.start`, they overlap → false. Else continue. Because they are ordered by start, a clash with a non-neighbor would already clash with someone in between after the sort. Touching (`prev.end ≤ next.start`) is fine. Unsorted input is why `[[7,10],[2,4]]` still works after the sort.

Do not merge into fewer intervals and then guess. Do not treat a shared endpoint as busy. Do not count rooms (that is 253).

**Time:** O(n log n)  
**Space:** O(log n) sort stack

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

Given `intervals[i] = [start, end]`, return the **minimum** number of rooms so every meeting gets a room. `[[0,30],[5,10],[15,20]]` → 2. `[[7,10],[2,4]]` → 1. n up to 10⁴, times up to 10⁶.

## Peak concurrent, not a yes/no

Meeting Rooms (252) asks whether **one** person can attend all (any overlap → false). Merge Intervals (56) unions ranges. Here overlap is allowed; you count how many overlap at once.

Each start occupies a room (`+1`). Each end frees one (`−1`). Because an end at `t` does not overlap a start at `t`, process the minus **at** `t` in the same bucket as the plus — they cancel, so touching meetings share a room.

If the max end is small, a difference array `d[start] += 1`, `d[end] -= 1`, then prefix-sum and take the max. If times are sparse, a map of those two updates, sort the keys, same running sum. Heap twin: sort by start; a min-heap of end times is the rooms in use — if the next start is ≥ the earliest end, pop (reuse); else push a new room; answer is max heap size.

Do not return a boolean (that is 252). Do not merge into one interval and output 1. Do not treat touching as needing two rooms.

**Time:** O(n log n) for the map/heap; O(n + m) for a dense difference array of size m  
**Space:** O(n) or O(m)

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

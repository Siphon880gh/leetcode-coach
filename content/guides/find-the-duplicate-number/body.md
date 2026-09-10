`nums` has length `n + 1`; each value is in `1 .. n`. Exactly one value repeats (two or more times). Return that value. Do **not** mutate `nums`. O(1) extra. `[1,3,4,2,2]` → `2`. `[3,1,3,4,2]` → `3`. `[3,3,3,3,3]` → `3`. n up to 1e5. Follow-up: linear time. Pigeonhole: n+1 pigeons into n holes.

## Count ≤ mid, or walk nums[i] as next

Contains Duplicate uses a set (O(n) extra). First Missing Positive seats values in place (mutates). Linked List Cycle / Cycle II run Floyd on real nodes. Here the constraints kill the set and the in-place swap.

**Pigeonhole binary search:** search `x` in `1 .. n`. Count how many `v` satisfy `v ≤ x`. If that count is greater than `x`, the duplicate sits in `1 .. x` (`r = mid`); else in `x+1 .. n` (`l = mid + 1`). Return `l`. Each probe is O(n), so O(n log n). Sorting would either mutate or copy.

**Floyd (linear):** treat index `i` as a node and `nums[i]` as `next`. Values in `1 .. n` always point inside the array; the extra copy of the duplicate creates a cycle whose **entrance** is that value. Same two loops as Cycle II: slow 1 / fast 2 until they meet, then one pointer from 0 and one from the meet, both step 1; they meet at the duplicate. XOR of `1 .. n` with the array fails when the duplicate appears three or more times.

**Time:** O(n log n) binary search; O(n) Floyd  
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

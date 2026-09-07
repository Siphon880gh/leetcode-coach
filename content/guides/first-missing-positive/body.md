Unsorted `nums`. Return the smallest positive integer that is not in the array. Must be O(n) time and O(1) extra space. n ≤ 10⁵.

`[1,2,0]` → 3. `[3,4,-1,1]` → 2. `[7,8,9,11,12]` → 1.

## Seat x at index x-1

The answer is in `1 .. n+1`. If `1..n` are all present, the answer is `n+1`. Negatives, zeros, and values larger than `n` cannot be that missing positive, so they are junk for seating.

Treat the array as a hash map: value `x` belongs at index `x - 1`. For each `i`, while `nums[i]` is in `[1, n]` and `nums[i] != nums[nums[i] - 1]`, swap `i` with `nums[i] - 1`. The `while` (not a single swap) is required because the value that landed at `i` may also need to move. Stop when the slot already holds its own value (duplicates).

Then scan left to right. The first `i` with `nums[i] != i + 1` is the missing positive. If every slot matches, return `n + 1`.

A hash set of positives is O(n) extra and fails the space bound. Sorting is O(n log n).

**Time:** O(n) — each index is written to its seat at most once  
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

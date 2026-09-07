Start at index 0. From `i` you may land on any index in `i .. i + nums[i]` (in bounds). Return the **minimum** number of jumps to `n-1`. You are guaranteed to be able to finish. n ≤ 10⁴.

`[2,3,1,1,4]` → 2 (0 → 1 → 4). `[2,3,0,1,4]` → 2.

## Jump when the range ends

This is BFS on a line: each jump is one layer. You do not need a queue.

Hold `end` (last index of the current layer) and `far` (farthest index any index in this layer can reach). Walk `i` from 0 through `n-2`:

- `far = max(far, i + nums[i])`
- When `i == end`, the layer is done: `ans += 1`, set `end = far`

You never decide “which landing is best” at a single `i`. You only commit a jump when you have seen every launch pad in the current range. Jump Game (55) only asks whether `far` ever covers the end; here you count how many times `end` is refreshed.

**Time:** O(n)  
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

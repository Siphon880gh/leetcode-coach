Right-rotate `nums` by `k` steps, in place, no return value. `k` is 0 or more. `[1,2,3,4,5,6,7]`, k = 3 → `[5,6,7,1,2,3,4]`. `[-1,-100,3,99]`, k = 2 → `[3,99,-1,-100]`. Length up to 1e5.

## Three reverses, k modulo n

Rotate List does this on a linked list (gap of k, then cut). Reverse Words II uses the same two-pointer reverse on a char array. Here: `k %= n` so a full turn is a no-op. Then:

1. Reverse the whole array.
2. Reverse the first `k` cells (the new prefix — they were the old suffix, now spelled backward).
3. Reverse from index `k` to the end.

`[1,2,3,4,5,6,7]`, k = 3: whole → `[7,6,5,4,3,2,1]`; first 3 → `[5,6,7,4,3,2,1]`; rest → `[5,6,7,1,2,3,4]`. If `k` becomes 0, the first reverse and the last reverse cancel. Copying into a new array at `(i + k) % n` is the extra-space twin; the follow-up wants O(1) extra.

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

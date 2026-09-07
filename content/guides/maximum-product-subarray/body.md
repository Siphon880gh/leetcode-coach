Nonempty contiguous subarray with the largest product. `[2,3,-2,4]` → 6 from `[2,3]`. `[-2,0,-1]` → 0, not 2, because `[-2,-1]` is not a subarray. `n` ≤ 2e4.

## Track max and min ending here

Sum Kadane drops a negative prefix. Here a negative can flip a tiny product into a large one later. Jump Game and Reverse Words are different problems. The whole array may include a 0 or extra negatives. Only tracking the running max (one scalar like sum Kadane) fails: after `-2` in `[2,3,-2,4]`, the max ending is `-2`, but the min ending is `-6`. Then ×4 turns `-6` into `-24` and also 4 itself; you still need the min from the previous step.

`ans = f = g = nums[0]`. For each later `x`, snapshot `ff`, `gg` then `f = max(x, ff×x, gg×x)` and `g = min(x, ff×x, gg×x)`; `ans = max(ans, f)`. Snapshot so both updates see the old pair. Include `x` alone: a 0 (or a fresh start) must reset the product; you may begin a new subarray at `x`. After 0 the product is 0. The next number starts a new subarray.

Subarray must be contiguous. Answer fits 32-bit. `[2,3,-2,4]` is 6 — `[2,3]`; later 4 alone is 4, and `3×(-2)×4` is `-24`. Skipping `-2` is not a subarray.

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

`nums` is sorted non-decreasing. Compact unique values to the front in the same order. Return `k`, the unique count. The judge only reads `nums[0..k-1]`. n up to 3×10⁴, in-place O(1) extra space.

`[1,1,2]` → k = 2, prefix `[1,2]`. `[0,0,1,1,1,2,2,3,3,4]` → k = 5, prefix `[0,1,2,3,4]`.

## Slow write index

`k = 0`. For each `x` in `nums`: if `k == 0` or `x != nums[k-1]`, write `nums[k] = x` and `k += 1`. Because the array is sorted, comparing to the last kept value is enough.

Same pattern generalizes: keep at most `t` copies by comparing to `nums[k-t]` (LeetCode 80 uses t = 2).

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

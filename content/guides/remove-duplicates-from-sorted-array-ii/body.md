Sorted `nums`, in place, each value at most twice. Return `k` for the kept prefix. O(1) extra. n up to 3 × 10^4.

`[1,1,1,2,2,3]` → k = 5, `[1,1,2,2,3]`. `[0,0,1,1,1,1,2,3,3]` → k = 7, `[0,0,1,1,2,3,3]`.

## Keep at most two

Problem 26 compares `nums[k-1]` and keeps a single copy. Here two 1s stay; only the third is dropped. Remove Element drops every `val`. Sort Colors is a void partition. Do not allocate a second array.

Write pointer `k` starts at 0. Keep `x` when `k < 2` or `x != nums[k-2]`. `nums[k]` is the next write slot, still stale; the kept prefix is `nums[0..k)`. Return `k` — the judge reads `nums[0..k)`; junk past `k` is fine.

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

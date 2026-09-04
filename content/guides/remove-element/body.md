Drop every `val` in place. Return `k`, the count of remaining values. The judge sorts `nums[0..k-1]` and ignores the rest. n ≤ 100.

`[3,2,2,3]`, val = 3 → k = 2, prefix two `2`s. `[0,1,2,2,3,0,4,2]`, val = 2 → k = 5 (the non-2s in any order).

## Same write pointer as LC 26

`k = 0`. For each `x`, if `x != val`, `nums[k] = x` then `k += 1`. Unlike Remove Duplicates, the array is unsorted and you skip a target value, not equal neighbors.

Two-pointer swap from the end also works (overwrite `val` with the last keeper) when you want fewer writes.

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

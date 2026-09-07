Rearrange `nums` in place to the next lexicographic permutation. If it is already the last (strictly non-increasing), wrap to the first: ascending order. O(1) extra memory. n ≤ 100.

`[1,2,3]` → `[1,3,2]`. `[2,3,1]` → `[3,1,2]`. `[3,2,1]` → `[1,2,3]`. `[1,1,5]` → `[1,5,1]`.

## Pivot, successor, reverse

Walk from the right. Let `i` be the last index with `nums[i] < nums[i+1]` (the pivot). If none, the whole array is descending: reverse it and stop.

Otherwise walk from the right again and find the last `j` with `nums[j] > nums[i]` (smallest tail value that still beats the pivot, because the tail is descending). Swap `i` and `j`. Reverse `nums[i+1:]` so that tail becomes the smallest possible.

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

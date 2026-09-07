Rotated sorted `nums`, duplicates allowed. Return whether `target` is present. n ≤ 5000.

`[2,5,6,0,0,1,2]`, 0 → true, 3 → false.

## Shrink when mid equals right

Problem 33 has distinct values, so one half is always strictly sorted, and it returns an index. Here `nums[mid] == nums[r]` can hide which side wraps. This is not Search a 2D Matrix’s flatten (each row starts after the previous ends).

Compare `mid` to `nums[r]`. Equal → `r -= 1`. Greater → `[l, mid]` is ordered; keep it when `nums[l] <= target <= nums[mid]`. Less → the right is ordered. When `l` meets `r`, return `nums[l] == target` — a boolean, not an index.

All-equal prefixes force `r` to walk down one by one, so worst case O(n), extra O(1). That is the follow-up: you cannot always claim O(log n).

**Time:** O(n) worst case  
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

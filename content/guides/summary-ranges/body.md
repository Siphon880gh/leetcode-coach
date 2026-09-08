Sorted unique `nums`. Cover every value with the smallest list of inclusive ranges, as strings: `"a->b"` when `a ≠ b`, else `"a"`. No extra integers. `[0,1,2,4,5,7]` → `["0->2","4->5","7"]`. `[0,2,3,4,6,8,9]` → `["0","2->4","6","8->9"]`. Length 0 to 20. Empty → `[]`.

## Two pointers on already-sorted uniques

Merge Intervals unions overlapping `[start, end]` pairs. Missing Ranges (163) emits the **holes**. Here the array is already sorted and unique; you only glue values that differ by exactly 1.

`i = 0`. While `i < n`: set `j = i`, then while `j + 1 < n` and `nums[j + 1] == nums[j] + 1`, increment `j`. Format `[i, j]`: one index → `str(nums[i])`; else `f"{nums[i]}->{nums[j]}"`. Then `i = j + 1`. Do not join across a gap of 2 (`0` and `2` stay separate). Do not use a hyphen minus that looks like a negative (`->` is the required arrow). Do not invent numbers that are not in `nums`.

**Time:** O(n)  
**Space:** O(1) extra besides the answer

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

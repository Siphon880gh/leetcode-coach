Pick three distinct indices so `nums[i] + nums[j] + nums[k]` is as close as possible to `target`. Return that **sum**, not the indices. The input has exactly one closest answer. n ≤ 500.

`[-1,2,1,-4]`, target `1` → `2` (`-1 + 2 + 1`). `[0,0,0]`, target `1` → `0`.

## Same skeleton as 3Sum

Sort, then for each `i` set `j = i + 1`, `k = n - 1`. Let `t = nums[i] + nums[j] + nums[k]`.

- If `t == target`, return `t` (cannot beat exact).
- If `|t - target|` is smaller than the best so far, store `t`.
- If `t > target`, `k--` (need a smaller third); else `j++`.

Unlike 3Sum you do not skip duplicates for uniqueness — you only care about the nearest numeric sum.

**Time:** O(n²) after sort  
**Space:** O(log n) or O(n) for the sort

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

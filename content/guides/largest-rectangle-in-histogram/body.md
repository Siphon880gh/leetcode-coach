Bars of width 1; return the largest rectangle area. n up to 10^5.

`[2,1,5,6,2,3]` → 10. `[2,4]` → 4.

## Monotonic stack of bars

Trapping Rain Water sums units above bars. Container With Most Water uses two ends as walls. Maximal Rectangle is a later 2D grid. Here a rectangle must sit under a chosen height across a contiguous span. Nested pairs are O(n²) and time out.

For each bar as height, nearest shorter index on the left and right. `left[i]` starts at −1, `right[i]` at n. Stack holds indices of strictly rising bars. When `heights[stk[-1]] >= h`, that index’s right bound is `i`. After the pops, `left[i]` is the new top (or −1). Area is `h × (right − left − 1)`: the open interval between the first shorter neighbors. Example 1: height 5 over width 2 is 10.

Return that maximum integer, not trapped water and not a list of bars.

**Time:** O(n)  
**Space:** O(n)

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

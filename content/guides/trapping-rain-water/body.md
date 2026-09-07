`height[i]` is a bar of width 1. After rain, water sits above a bar only if both sides have a taller wall. Return the total units trapped. n ≤ 2×10⁴.

`[0,1,0,2,1,0,1,3,2,1,2,1]` → 6. `[4,2,0,3,2,5]` → 9.

## Min of left and right max

At index `i`, the water line is `min(tallest to the left including i, tallest to the right including i)`. Units there are that line minus `height[i]` (never negative). Prefix and suffix max arrays compute this in O(n) time and O(n) space.

Two pointers drop the arrays. Hold `L`, `R`, `leftMax`, `rightMax`. The side with the **smaller** running max is the one whose water you can settle now: its water line cannot rise above that smaller max, no matter what the far side still hides.

- If `leftMax <= rightMax`, add `leftMax - height[L]` (if positive), step `L` right, refresh `leftMax`.
- Else do the same from `R` going left.

A monotonic stack that pops when a taller bar closes a valley also works; the two-pointer pass is the same formula with O(1) extra memory.

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

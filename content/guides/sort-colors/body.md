Sort an array of only 0, 1, and 2 in place (red, white, blue). No library sort. Follow-up: one pass, O(1) extra.

`[2,0,2,1,1,0]` → `[0,0,1,1,2,2]`. `[2,0,1]` → `[0,1,2]`.

## Three pointers, Dutch flag

Count-then-rewrite is two passes. Bubble is extra comparisons. Use `i = -1` (right edge of the 0-block), `j = n` (left edge of the 2-block), and `k = 0` walking the unknown middle while `k < j`.

On 0: swap with `i + 1`, then `i++` and `k++`. On 2: swap with `j - 1`, then `j--` — do not increment `k`; the value swapped in from the right is unexamined. On 1: only `k++`. The method returns void. This is not Merge Sorted Array’s extra buffer.

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

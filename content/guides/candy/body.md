n children in a line. Each gets at least 1 candy. A strictly higher rating than a neighbor must get strictly more candies than that neighbor. Return the minimum total. `n` up to 5e4.

`[1,0,2]` → `5` (`2,1,2`). `[1,2,2]` → `4` (`1,2,1`).

## Left slope, right slope, then max

Giving `ratings[i]` candies overspends. Gas Station resets a tank. One left-to-right pass that only beats the left neighbor fails on a peak: on `[1,0,2]` the last child can be left with 1 while the left slope already used `2,1` — the right constraint is missing. Trapping Rain Water mins two height maxima. Equal ratings may share a candy count — `[1,2,2]` ends `1,2,1`, not a forced difference of 1.

`left[i] = 1`, and if `ratings[i] > ratings[i-1]` then `left[i] = left[i-1] + 1`. Mirror from the right into `right[i]`. Equals do not bump. The candy at `i` is `max(left[i], right[i])`: both neighbor inequalities on **one** pile, fewest candies. Do not sum the two arrays (they are not separate piles) and do not min them.

Return the sum of those maxes — `2+1+2=5` and `1+2+1=4` — not the assignment array, and not `left` alone.

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

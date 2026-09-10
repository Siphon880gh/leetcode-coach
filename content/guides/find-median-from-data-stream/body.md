Online median: `addNum(num)` then `findMedian()`. Odd count: middle value. Even count: mean of the two middles. At least one number before `findMedian`. Up to 5×10⁴ calls. Add 1, add 2 → 1.5. Add 3 → 2.0.

## Two heaps, not a full sort each query

Sliding Window Median (480) is a window, not the whole stream. Kth Largest (215) asks one order statistic of a fixed array. Here the set grows.

`maxQ` holds the **smaller** half (max-heap; its top is the largest small value). `minQ` holds the **larger** half (min-heap; its top is the smallest large value). Invariant: every value in `maxQ` is ≤ every value in `minQ`, and `minQ` is the same size as `maxQ` or one larger.

`addNum`: push `num` onto `maxQ`, pop that new max into `minQ`. If `len(minQ) − len(maxQ) > 1`, pop `minQ` back onto `maxQ`. `findMedian`: equal sizes → average of both tops; else `minQ` top.

Do not sort the whole history on every query. Do not dump into one unsorted list and scan. Do not skip rebalance (otherwise `minQ` can drift two ahead and the median is no longer either top).

**Time:** O(log n) per add, O(1) median  
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

Merge overlapping `[start, end]` ranges into a cover with no overlaps. n ≤ 10⁴. A shared endpoint counts as overlap.

`[[1,3],[2,6],[8,10],[15,18]]` → `[[1,6],[8,10],[15,18]]`. `[[1,4],[4,5]]` → `[[1,5]]`. Input may be unsorted: `[[4,7],[1,4]]` → `[[1,7]]`.

## Sort, then extend the right end

Sort by left endpoint first. Neighbors in the given list are not time-neighbors — without the sort, `[4,7]` and `[1,4]` never sit next to each other.

Hold an open range `[st, ed]`. For each next `[s, e]`:

- If `ed < s`, the gap is real: flush `[st, ed]` and start a new open range.
- Else they overlap or touch: `ed = max(ed, e)` so a nested interval cannot shrink the cover.

Flush the last open range after the loop. Insert Interval assumes a list that is already sorted and merged plus one new range — here you merge an arbitrary pile.

**Time:** O(n log n) from the sort  
**Space:** O(log n) sort stack (plus the answer list)

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

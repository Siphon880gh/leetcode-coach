Reverse only the sublist from 1-indexed `left` to `right`. n ≤ 500.

`[1,2,3,4,5]`, left = 2, right = 4 → `[1,4,3,2,5]`. `[5]`, left = 1, right = 1 → `[5]`.

## One segment, then relink

A full reverse would put 5 first. Reverse Nodes in k-Group flips disjoint windows. Rotate List moves the tail to the front. Swap Nodes in Pairs flips fixed pairs. Prefix and suffix stay put.

If `left == right` or the list has one node, return `head`. Dummy, then walk `left - 1` steps to the node before the segment. Reverse `right - left + 1` nodes. Relink: `p.next` is the new segment head, old-head.next is the leftover. When `left` is 1, the original head moves — return `dummy.next`. Rewire next pointers; do not copy values.

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

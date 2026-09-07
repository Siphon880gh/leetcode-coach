Min depth is nodes on the shortest root-to-leaf path. A leaf has no children. Empty is allowed.

`[3,9,20,null,null,15,7]` → `2`. Skewed `[2,null,3,null,4,null,5,null,6]` → `5`.

## Shortest path to a real leaf

Max Depth is `1 + max` of both sides. Blind `1 + min(left, right)` would treat a missing child as a leaf — the skewed sample would return `1`, not `5`. Balanced Tree is a boolean. Level Order is nested lists.

If `root` is `None`, return `0`. If `left` is `None`, return `1 + minDepth(right)`. If `right` is `None`, return `1 + minDepth(left)`. Else return `1 + min` of both. You must reach a node with two nulls. Empty tree is `0`. A single node is `1`. Return that integer — not Max Depth’s longer path (`3` vs `2` on the first sample, because `9` is a nearer leaf).

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

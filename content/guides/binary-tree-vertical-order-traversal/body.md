Given `root`, group values by vertical column, each column top to bottom. Same row and column: left to right. Empty tree → `[]`. Sample `[3,9,20,null,null,15,7]` → `[[9],[3,15],[20],[7]]`. Sample `[3,9,8,4,0,1,7]` → `[[4],[9],[3,0,1],[8],[7]]` (0 and 1 share the root’s column under 3). Up to 100 nodes.

## BFS already orders a column; 987 is a different sort

Right Side View (199) keeps one node per depth. Vertical Order Traversal of a Binary Tree (987) sorts ties by **value**. Here ties stay left-to-right, not sorted by value.

Put `(root, 0)` in a queue. Left child is `offset − 1`, right is `offset + 1`. Append `val` into a map keyed by offset. Enqueue left then right so the same row is left-to-right. When the queue drains, return the lists in increasing offset order (`sorted` keys, or track min/max column and walk the range). BFS visits shallower nodes first, so you do not need a depth sort.

DFS can store `(depth, val)` per column and sort by depth (stable, so same-depth left-to-right from visit order). Extra log. Prefer BFS.

Do not sort a column by node value (that is 987). Do not skip a column that has a hole above it — still emit the values that exist. Do not treat inorder as vertical order.

**Time:** O(n) if you walk min..max column; O(n log n) if you sort the keys  
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

N-ary tree, 0 to 1e4 nodes, height at most 1000. Return values grouped by level, left to right. Empty root → `[]`. `[1,null,3,2,4,null,5,6]` → `[[1],[3,2,4],[5,6]]`.

## BFS one level at a time

If root is null, return empty. Push the root. While the queue is nonempty, note `k =` current length. Pop `k` nodes: append each value to this level’s list, then `extend` with that node’s full `children` list (zero or more). Push the level list onto the answer.

Binary Tree Level Order Traversal (102) only walks left then right. Serialize and Deserialize N-ary Tree (428) needs `#` terminators for a round-trip string, not a list of levels. N-ary Tree Preorder (589) and Postorder (590) are DFS orders.

Do not flatten into a single list. Do not skip nodes with an empty children list (they still belong on their level). Do not mix two levels in one inner loop — freeze the count before you enqueue children.

Time: O(n)  
Space: O(n)

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

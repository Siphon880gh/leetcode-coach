Return inorder values of a binary tree. Up to 100 nodes.

`[1,null,2,3]` → `[1,3,2]`. Empty → `[]`. `[1]` → `[1]`.

## Left, visit, right

Preorder visits the root first. Level order walks by BFS. Postorder visits the node after both children. The sample is 1, 3, 2 — left subtree of 2 before 2 itself. Valid Parentheses matches delimiters. Restore IP splits a string. Unique Binary Search Trees later builds trees.

DFS: if `root` is None, return without appending. Recurse left, append `root.val`, recurse right. An iterative stack that pushes the left spine, pops, then goes right, yields the same order. Return the list of values, not a rebuilt tree.

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

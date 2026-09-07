Is this binary tree a BST? `[2,1,3]` → true. `[5,1,4,null,null,3,6]` → false (4 sits right of 5). Nodes 1..10⁴. A node may hold `INT_MIN`.

## Inorder must strictly increase

Only checking `left.val < node.val < right.val` misses a far descendant: 3 can sit in 5’s right subtree under 6 and still look fine next to 6. Unique BST I counts shapes. Inorder Traversal returns the values. BFS does not encode BST order.

Null is valid. After the left subtree, if `prev ≥ root.val` return false; then `prev = root.val`; then the right subtree. Start `prev` at −∞, not `INT_MIN` (that value can appear). The BST definition forbids equal keys. Return the boolean from `dfs(root)` — true iff the whole inorder walk stayed strictly increasing, not the inorder list.

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

Is the tree a mirror of itself around the center? Nodes 1..1000.

`[1,2,2,3,4,4,3]` → true. `[1,2,2,null,3,null,3]` → false.

## Left mirrors right

Same Tree compares identical positions on two roots. A mirror pairs outer children with outer children and inner with inner. Validate BST is about sorted keys. An inorder palindrome can miss a null vs a node on the opposite side.

`dfs(a, b)`: both `None` → true. One `None` or unequal values → false. Else both `dfs(a.left, b.right)` and `dfs(a.right, b.left)`. The left child of the left half must match the right child of the right half. Return `dfs(root.left, root.right)`. A single-node tree is symmetric. Return a boolean, not a new tree.

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

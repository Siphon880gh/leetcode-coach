A binary tree, 1 to 1000 nodes. Return the sum of every left leaf: a node with no children that is the left child of its parent. `[3,9,20,null,null,15,7]` → `24` because 9 and 15 are left leaves (7 is a right leaf). A lone root `[1]` is not anyone’s left child → `0`.

## Recurse right; on the left, add only if both children are missing

If `root` is empty, return 0. Always add the answer from the right subtree. If there is a left child: when both of that child’s children are missing (`left.left` and `left.right` are the same `None`), add `left.val`; otherwise recurse into the left subtree. An iterative stack does the same test when it sees a left child.

The `left.left == left.right` check is a compact leaf test (both `None`). A left child with its own kids is an internal node — keep walking.

Maximum Depth (104) only measures height. Binary Tree Paths (257) lists every root-to-leaf string. Sum Root to Leaf Numbers (129) uses full paths, not “is this a left child.”

Do not add 20 (it is not a leaf). Do not add 7. Do not treat the root as a left leaf. Do not add a left child that still has descendants.

Time: O(n)  
Space: O(n) recursion / stack

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

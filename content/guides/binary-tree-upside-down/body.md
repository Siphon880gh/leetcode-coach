Turn a binary tree upside down and return the new root. Original left becomes the new root; original root becomes the new right; original right becomes the new left. `[1,2,3,4,5]` → `[4,5,2,null,null,3,1]`. Empty → empty. `[1]` → `[1]`. Every right has a left sibling and no children. At most 10 nodes.

## Recurse the left spine; rewire on the way up

Invert Binary Tree swaps children under the same root; 1 would still be the root. Flatten Binary Tree to Linked List hangs a right spine. Level reverse is zigzag or level-order II. None of those move the root to the old leftmost leaf.

Base: empty or no left → return this node. Else `new_root = recurse(root.left)`. Then `root.left.right = root`; `root.left.left = root.right`; `root.left = root.right = None`. Return `new_root`, not the old root. The leftmost leaf is the answer; each unwind attaches the old parent as the new right and the old right as the new left.

Clear the old children. After 2 becomes parent of 1, if 1 still points at 2 you get a cycle. Flatten keeps a right spine on purpose; this problem must break the old edges.

Do not recurse on the right: the guarantee says every right is a leaf. `[1,2,3,4,5]` is rooted at 4; 5 is 4’s left and 2 is 4’s right. Time O(n), extra O(height) from the left-spine recursion.

**Time:** O(n)  
**Space:** O(height)

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

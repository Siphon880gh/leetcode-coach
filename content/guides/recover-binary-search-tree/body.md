Exactly two nodes in a BST had their values swapped. Recover it in place; do not change structure. Nodes 2..1000.

`[1,3,null,null,2]` → swap 1 and 3. `[3,1,4,null,null,2]` → swap 3 and 2.

## Swap the two inorder inversions

Validate BST only answers yes/no. Unique BST II builds every shape from `1..n`. Here the shape is already correct; two values sit in the wrong nodes. Do not allocate a new tree.

Inorder of a BST is almost sorted: one drop (adjacent swap) or two drops (far swap). Walk left, then: if `prev` exists and `prev.val > root.val`, set `first = prev` on the first drop, and always set `second = root`. Then `prev = root`, walk right. `first` stays the earlier high; `second` becomes the last inorder value that is too small. After the walk, swap `first.val` and `second.val`. The function is void.

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

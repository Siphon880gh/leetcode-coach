`preorder` is unique integers. Return true iff it is the preorder of some BST. `[5,2,1,3,6]` → true. `[5,2,6,1,3]` → false (1 appears after you already went right of 5). Length up to 10⁴. Follow-up: O(1) extra space.

## Once you leave a left subtree, nothing smaller may appear

Validate BST (98) walks an **existing** tree inorder. Reconstructing the tree from preorder then validating is O(n) extra. Inorder of a BST is sorted, but this array is **preorder**: root, then the whole left (all smaller), then the whole right (all larger). After the first value greater than a node, you have left that node’s left subtree — later values must be `≥` that node.

Keep a **decreasing** stack (the path of open ancestors). `last` starts at −∞. For each `x`: if `x < last`, false. While the top is `< x`, pop it into `last` (those nodes’ left subtrees are done; `last` is the new floor). Then push `x`. `[5,2,6,1,3]` pops 2 then 5 when 6 arrives, so `last` is 5, and 1 fails.

O(1) extra: treat a prefix of the input array as the stack (write popped `last` back into a write index). Do not sort the array (that is inorder). Do not allow `x < last` after a right turn. Do not only check adjacent pairs.

**Time:** O(n)  
**Space:** O(n) stack, or O(1) if you reuse the array

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

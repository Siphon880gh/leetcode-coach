BST `root` and a node `p` in it. Return `p`’s inorder successor: the node with the **smallest key greater than `p.val`**, or `null` if none. Unique values. `[2,1,3]`, `p = 1` → `2`. `[5,3,6,2,4,null,null,1]`, `p = 6` → `null`. Up to 1e4 nodes.

## Candidate when greater; then hunt left

Kth Smallest walks inorder until the k-th visit. LCA of a BST walks until p and q split. Inorder Successor in BST II uses parent pointers. Here you have only `root` and `p`.

`ans = null`. While `root`: if `root.val > p.val`, this node is a successor candidate — set `ans = root` and go **left** (a smaller key may still beat `p`). Else `root` is ≤ `p`, so go **right**. The last candidate is the tightest upper bound. If `p` has a right child, that walk ends at the leftmost node of the right subtree — same as the textbook “if right exists, min of right.”

Do not dump the whole inorder list then scan for `p`. Do not return the first node greater than `p` on a preorder walk (that may not be the smallest greater). Do not treat `p`’s parent as always the successor (`1` under `2` is, but `4` under `3` in a larger tree is not).

**Time:** O(h)  
**Space:** O(1)

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

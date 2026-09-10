BST `root` and a float `target`. Return the node value closest to `target`. If two values are equally close, return the **smaller**. `[4,2,5,1,3]`, target `3.714286` → `4`. Single node `[1]`, any target → `1`. Up to `10⁴` nodes.

## One search path; update on a tighter (or equal-and-smaller) gap

Kth Smallest walks full inorder. LCA of a BST forks when p and q split. Closest Binary Search Tree Value II asks for the k nearest. Here you need **one** value.

Start `ans = root.val`. While the node is not null: `gap = abs(node.val − target)`. If `gap` is smaller than the best so far, or equal and `node.val < ans`, keep this value. Then `node = node.left` if `target < node.val`, else `node.right`. You never visit both children. Inorder of the whole tree also works but is O(n). Ties: 2 and 4 equally far from 3 would pick 2.

Do not dump every value into a list and scan. Do not recurse into both subtrees. Do not pick the larger on a tie.

**Time:** O(h), O(n) worst  
**Space:** O(1) iterative

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

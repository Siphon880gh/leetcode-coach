BST `root`, nodes `p` and `q` (distinct, both present, unique values). Return their lowest common ancestor. A node is an ancestor of itself. `[6,2,8,0,4,7,9,…]`, `p=2`, `q=8` → `6`. Same tree, `p=2`, `q=4` → `2`. `[2,1]`, `p=2`, `q=1` → `2`. Up to `10⁵` nodes.

## BST order points at the fork

Kth Smallest walks inorder. Validate BST checks that inorder strictly increases. LCA of a Binary Tree (236) cannot assume left < node < right, so it searches both subtrees. Here the search path is unique: from `root`, while true: if `root.val < min(p.val, q.val)` go right; elif `root.val > max(p.val, q.val)` go left; else return `root` — one value sits on each side, or `root` is `p` or `q`.

Do not parent-walk both nodes to the root and scan (O(n) extra). Do not recurse into both children on every node (that is 236). Do not require the LCA to be strictly above `p` and `q` (`2` is the LCA of `2` and `4`).

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

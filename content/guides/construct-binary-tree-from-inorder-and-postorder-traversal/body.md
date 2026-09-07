Build the tree from inorder and postorder. Values are unique. Length 1..3000.

`inorder = [9,3,15,20,7]`, `postorder = [9,15,7,20,3]` → `[3,9,20,null,null,15,7]`. A single value `[-1]` is one node.

## Postorder last is root

Problem 105 takes `preorder[0]` as the root. Postorder finishes at the root — `postorder[0]` here would pick 9, a left leaf, not 3. Reversing preorder is not postorder (left still comes before right). Unique BST II enumerates Catalan trees. Level Order lists rows.

Map each inorder value to its index. `dfs(i, j, n)` builds `n` nodes from inorder starting at `i` and postorder starting at `j`. If `n ≤ 0`, return `None`. `v = postorder[j+n-1]`, `k` is `v`’s inorder index. Left size is `k - i`. Left: `dfs(i, j, k-i)`. Right: `dfs(k+1, j+k-i, n-k+i-1)` — postorder is left, then right, then root, so skip the left block of size `k-i`. Return `dfs(0, 0, len(inorder))` — the root, not a boolean, depth, or the inorder list.

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

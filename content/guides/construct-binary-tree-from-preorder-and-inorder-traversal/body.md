Build the tree from preorder and inorder. Values are unique. Length 1..3000.

`preorder = [3,9,20,15,7]`, `inorder = [9,3,15,20,7]` → `[3,9,20,null,null,15,7]`. A single value `[-1]` is one node.

## Preorder root, split inorder

Inorder Traversal emits values; here you already have those lists and must allocate nodes. Unique BST II enumerates Catalan trees. Max Depth returns a number. Level Order is BFS rows, not root-left-right. Same Tree compares two trees.

Map each inorder value to its index (unique keys → O(1) lookup). `dfs(i, j, n)` builds `n` nodes from preorder starting at `i` and inorder starting at `j`. If `n ≤ 0`, return `None`. `v = preorder[i]`, `k` is `v`’s inorder index. Left size is `k - j`. Left: `dfs(i+1, j, k-j)`. Right: `dfs(i+1+k-j, k+1, n-k+j-1)`. Return `dfs(0, 0, len(preorder))` — the root, not a boolean.

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

`nums` is strictly increasing; convert it to a height-balanced BST. Length 1..10⁴.

`[-10,-3,0,5,9]` accepts `[0,-3,9,-10,null,5]`. `[1,3]` accepts `[3,1]` or `[1,null,3]`.

## Mid of the slice is root

Unique BST II enumerates every Catalan shape. Unique BST I returns a count. Level Order lists rows. Construct from inorder and postorder needs two arrays. Here `nums` is already the inorder of the tree you must build.

`dfs(l, r)`: if `l > r`, return `None`. `mid = (l + r) >> 1`. Root is `nums[mid]`; left is `dfs(l, mid-1)`, right is `dfs(mid+1, r)`. Always taking `nums[l]` as root makes a linked-list spine, which is not height-balanced. Floor or ceil mid both work — the sample accepts more than one tree. Return `dfs(0, n-1)`, the constructed root, not a count and not nested level lists.

**Time:** O(n)  
**Space:** O(log n)

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

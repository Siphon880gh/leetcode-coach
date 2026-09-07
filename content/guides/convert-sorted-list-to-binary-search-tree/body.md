Sorted singly linked list → height-balanced BST. Up to 2×10⁴ nodes. Empty head → empty tree.

`[-10,-3,0,5,9]` accepts `[0,-3,9,-10,null,5]`.

## Array first, then mid

Problem 108 indexes `nums[mid]` in O(1). A `ListNode` only has `.next`. Unique BST II enumerates Catalan trees. Level Order lists rows. Always using the list head as root makes a right spine, which is not height-balanced.

Walk the list into an array (`nums.append(head.val)`). Then `dfs(i, j)`: if `i > j`, return `None`. `mid = (i + j) >> 1`; left `dfs(i, mid-1)`, right `dfs(mid+1, j)`; return `TreeNode(nums[mid], left, right)`. Empty list: `nums` is `[]`, so `i = 0 > j = -1` → `None`. Return that root — not the array, not nested level lists, not a Catalan count.

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

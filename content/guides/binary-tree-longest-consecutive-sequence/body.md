Binary tree `root`. Return the length of the longest path that **increases by one** at each step, parent to child only (no walking up). Path may start at any node. `[1,null,3,2,4,null,null,null,5]` → 3 (`3-4-5`). `[2,null,3,2,null,1]` → 2 (`2-3`, not `3-2-1`). Nodes 1..3×10⁴.

## Downward plus-one; reset when the child is not next

Longest Consecutive Sequence (128) is an unordered array. Binary Tree Longest Consecutive Sequence II (549) allows a path that goes through a node in both directions. Here you only go **down**, and only `child.val == parent.val + 1`.

`dfs(node)` returns the longest consecutive run **starting at this node** going down. Recurse left and right first. `l = dfs(left) + 1`, then if `left` exists and `left.val − node.val != 1`, set `l = 1` (this node is a new start). Same for the right child. `t = max(l, r)` is this node’s downward run. Update a global `ans` with `t`, then return `t` so the parent can extend or reset.

Do not count decreasing `3-2-1`. Do not walk to the parent. Do not treat any increasing path that skips values.

**Time:** O(n)  
**Space:** O(h) recursion

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

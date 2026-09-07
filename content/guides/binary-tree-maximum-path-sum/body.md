Max sum of any non-empty path of nodes (need not pass the root). Values can be negative. At least one node; up to 3e4.

`[1,2,3]` → `6` (`2-1-3`). `[-10,9,20,null,null,15,7]` → `42` (`15-20-7`).

## Bend at a node, hand one side up

Path Sum I/II start at the root and stop at a leaf. Here a path may bend through a node and skip the root entirely. Max Depth is height. Flatten 114 rewires a preorder spine. Triangle is a grid min. None of those pick a max-sum path that can turn.

`dfs` on `None` returns `0`. Else clamp `left = max(0, dfs(left))` and `right` the same — drop a negative child. Then `ans = max(ans, val + left + right)` (the bend). Return `val + max(left, right)` so the parent attaches to **one** chain only.

Start `ans` at negative infinity, not `0`: a tree of one node `-3` must return `-3`. Empty is not allowed; if every node is negative, the answer is the largest (least negative) node.

Return the global `ans` after `dfs(root)` — `6` or `42` — not a boolean, not a node list, and not `dfs(root)` itself. That return value is only the best chain going up; the bend `2-1-3` lives in the global.

**Time:** O(n)  
**Space:** O(n) for the call stack

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

Binary tree `root`, nodes `p` and `q` (distinct, both present, unique values). Return their lowest common ancestor. A node is an ancestor of itself. `[3,5,1,6,2,0,8,…]`, `p=5`, `q=1` → `3`. Same tree, `p=5`, `q=4` → `5`. `[1,2]`, `p=1`, `q=2` → `1`. Up to `10⁵` nodes.

## Recurse both children; a split is the answer

LCA of a BST (235) walks left or right by key order. Kth Largest Quickselects an array. This tree is not a BST, so you cannot compare `val` to choose a child.

`dfs(node)`: if `node` is null or is `p` or `q`, return `node`. Else `left = dfs(left)`, `right = dfs(right)`. If both are non-null, `p` and `q` sit on different sides — return `node`. Else return `left or right` (the side that found someone, or null). Because both targets exist, a single-sided hit is the ancestor that contains both (the other is nested under that hit), which is why `5` is the LCA of `5` and `4`. Compare **node identity**, not a copied `val`.

Do not parent-map to the root (O(n) extra, still correct). Do not stop at the first node whose `val` lies between `p.val` and `q.val` (BST trick; `4` can sit under `5`, not under `3`).

**Time:** O(n)  
**Space:** O(h)

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

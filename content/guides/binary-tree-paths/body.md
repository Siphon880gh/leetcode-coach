Given `root`, return every root-to-leaf path as a string, any order. A leaf has no children. `[1,2,3,null,5]` → `["1->2->5","1->3"]`. `[1]` → `["1"]`. Nodes 1 to 100.

## Record only at leaves; pop the node on the way up

Path Sum II (113) keeps paths whose **sum** hits a target. Binary Tree Level Order is BFS rows. Flatten rewires pointers. Here you want **every** root-to-leaf chain, formatted with `->` between values — not a sum, not an inorder dump.

`dfs(node)`: if `node` is null, return. Push `str(node.val)` onto a shared buffer `t`. If both children are null, append `"->".join(t)` to the answer (a new string; `t` will change). Else recurse left then right. Then `t.pop()` so the next sibling starts from the same prefix. A lone root is a leaf, so `["1"]` with no arrows. Do not emit a path at an internal node. Do not skip the pop (left values leak into the right path). Do not join with commas.

**Time:** O(n²) (each path copy/join can be O(n))  
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

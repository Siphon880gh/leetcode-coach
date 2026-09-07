Return preorder values of a binary tree. `[1,null,2,3]` → `[1,2,3]`. Empty → `[]`. Inorder of that tree would be `[1,3,2]`. Up to 100 nodes.

## Visit this node before either child

Inorder on the sample is `1,3,2`. Postorder is `3,2,1`. Level order happens to be `1,2,3` on this skinny tree but fails on a fuller one: `[1,2,3,4,5]` → preorder `[1,2,4,5,3]`, not BFS `[1,2,3,4,5]`. Floyd and Reorder List are list pointer tricks, not tree DFS order.

Recursive: if `root` is `None`, return. `ans.append(val)`; `dfs(left)`; `dfs(right)`. Visit this node before either child; left subtree before right.

Iterative: stack, pop, append, push right then left so left is on top. A stack pops last-in first; left must be processed next, so it is pushed second. Pushing left first would emit right-then-left.

`[1]` → `[1]`. `[]` → `[]`. Return the list of values, not a rebuilt tree, not inorder.

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

Return postorder values of a binary tree. `[1,null,2,3]` → `[3,2,1]`. Preorder of that tree is `[1,2,3]`. Inorder is `[1,3,2]`. Empty → `[]`. Up to 100 nodes.

## Both children first, this node last

Visit-first is preorder `[1,2,3]`. Visit-between is inorder `[1,3,2]`. BFS is `1,2,3` on this skinny tree. Floyd is a list cycle trick. Unique BST I’s Catalan count counts trees; it does not list values.

Recursive: if `root` is `None`, return. `dfs(left)`; `dfs(right)`; `ans.append(val)`. Postorder means the node is recorded only after its subtrees are done. Appending first is preorder and yields `[1,2,3]` on the sample. An iterative trick is the reverse of root-right-left preorder.

`[1]` → `[1]`. `[]` → `[]`. Return the list of values, not a rebuilt tree, not preorder.

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

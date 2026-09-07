Are trees `p` and `q` the same — same structure and same values? Up to 100 nodes each; either may be empty.

`[1,2,3]` vs `[1,2,3]` → true. `[1,2]` vs `[1,null,2]` → false. `[1,2,1]` vs `[1,1,2]` → false.

## Match structure and values

Inorder lists can collide or miss a missing child. Validate BST checks order on one tree. Symmetric Tree compares a tree to its mirror. Unique Paths counts grid walks.

If both nodes are `None`, true. If exactly one is `None`, or the values differ, false. Else return `isSame(p.left, q.left)` and `isSame(p.right, q.right)`. `[1,2]` vs `[1,null,2]` share values 1 and 2, but the 2 sits on opposite sides — null is structure, not the number 0. Two empty trees are the same. Return a boolean, not a merged tree.

**Time:** O(min(m, n))  
**Space:** O(min(m, n))

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

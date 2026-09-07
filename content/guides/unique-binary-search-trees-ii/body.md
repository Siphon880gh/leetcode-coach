All structurally unique BSTs using each value 1..n once. n ≤ 8.

`n = 3` → five trees. `n = 1` → `[[1]]`.

## Pick each root, cartesian kids

Unique Paths counts grid routes. Inorder lists values of one tree. Unique BST I returns the Catalan count. Every BST on 1..n has the same inorder — you need the shapes.

`dfs(i, j)`: if `i > j`, return a list containing `None` so a missing child is still one pairing (an empty list would drop every tree that should have a null child). Else each `v` in `i..j` is root; left trees on `[i, v-1]`, right on `[v+1, j]`; cartesian product, attach `TreeNode(v, l, r)`. Answer is `dfs(1, n)` — a list of roots, not a count and not repeated inorder arrays.

**Time:** O(n × G(n))  
**Space:** O(n × G(n))

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

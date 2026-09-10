Binary tree `root`. Return the size (node count) of the largest subtree that is also a BST. A subtree includes every descendant. Empty tree → 0. `[10,5,15,1,8,null,7]` → 3 (the `5 / 1, 8` side). Up to 1e4 nodes. Follow-up: O(n).

## Bottom-up: BST here, or poison the range

Validate Binary Search Tree (98) asks whether the whole tree is a BST. Maximum Sum BST in Binary Tree (1373) tracks sums. Here you only need the largest node count.

Post-order `dfs` returns `(min, max, size)` of the BST rooted at this node. Null: `(+inf, −inf, 0)` so a missing child never blocks `left.max < val < right.min`. If both children are BSTs and that inequality holds, this node is a BST of size `left.size + right.size + 1`; track a global max. Otherwise return a poison pair `(−inf, +inf, 0)` so no ancestor can treat this node as a valid child BST.

Do not check only immediate children (far descendants can still violate BST). Do not return the subtree root. Do not count nodes in a non-BST by summing poisoned sizes (use 0 on failure).

Time: O(n)  
Space: O(h) recursion

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

BST, 0 to 2000 unique-valued nodes. Convert in place to a sorted circular doubly linked list: `left` becomes prev, `right` becomes next. Return the smallest node. Empty tree → null. `[4,2,5,1,3]` → `1↔2↔3↔4↔5` with last linked back to first.

## Inorder stitch, then close the circle

Keep `head` and `prev`. DFS left, visit, DFS right. On visit: if `prev` exists, set `prev.right = node` and `node.left = prev`; else this is the smallest, so `head = node`. Then `prev = node`. After the walk, `prev` is the largest: `prev.right = head` and `head.left = prev`.

Flatten Binary Tree to Linked List (114) is a preorder right-spine, not a sorted circular DLL. Convert Sorted List to Binary Search Tree (109) goes the other direction. Do not allocate new nodes. Do not skip the circular close (the first’s prev must be the last). Do not use a level-order walk — that is not sorted.

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

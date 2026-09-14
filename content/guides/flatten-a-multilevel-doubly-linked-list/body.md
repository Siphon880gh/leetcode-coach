Doubly linked list, at most 1000 nodes. Each node has `prev`, `next`, and an optional `child` that starts another list (which may have children of its own). Flatten into one level: a child’s nodes go after `curr` and before `curr.next`. Every `child` must be null in the result. Empty → empty. Sample → `[1,2,3,7,8,11,12,9,10,4,5,6]`.

## Save next, dive into child, then resume

DFS with a dummy predecessor. On `cur`: link `pre.next = cur` and `cur.prev = pre`. Save `t = cur.next`. Recurse `preorder(cur, cur.child)` to get the tail of the spliced child. Set `cur.child = None`. Then `preorder(that tail, t)` so the original next comes after the child. Unlink the dummy’s next from pointing backward at the dummy.

Flatten Binary Tree to Linked List (114) is a preorder right-spine on a binary tree. Convert BST to Sorted Doubly Linked List (426) is inorder on a BST with no child pointer. Do not leave `child` set. Do not put the child after the whole remaining next-chain (it must sit immediately after `curr`). Do not drop the original `next` after a child splice.

Time: O(n)  
Space: O(n) recursion in the worst nested chain

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

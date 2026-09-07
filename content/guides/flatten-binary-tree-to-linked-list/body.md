Flatten in place into a preorder “linked list”: `right` is next, `left` is always `None`. Void. Up to 2000 nodes.

`[1,2,5,3,4,null,6]` → `[1,null,2,null,3,null,4,null,5,null,6]`. Empty stays empty. `[0]` stays `[0]`.

## Preorder spine on the right

Path Sum II copies values. A new `ListNode` chain would not use `TreeNode.left` / `right`. Inorder is left-visit-right; the required order is root, then left, then right.

While `root` is not `None`: if there is a left child, walk to that subtree’s rightmost node (the last node visited in the left subtree). Hang the old `root.right` off that predecessor. Set `root.right = root.left`, then `root.left = None`. If there is no left, skip the splice. Then `root = root.right`. Extra space O(1). Return nothing — the judge inspects the mutated tree.

**Time:** O(n)  
**Space:** O(1)

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

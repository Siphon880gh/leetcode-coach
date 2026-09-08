Binary tree `root`. Invert it (swap every left/right pair) and return the root. `[4,2,7,1,3,6,9]` → `[4,7,2,9,6,3,1]`. `[2,1,3]` → `[2,3,1]`. Empty → empty. Up to 100 nodes.

## Recurse both sides, then swap — save both first

Symmetric Tree only **checks** a mirror. Same Tree pairs the same child on two trees. Here you **mutate**. Count Complete Tree Nodes skipped a perfect half; you still visit every node.

If `root` is null, return null. Recurse `invert(left)` and `invert(right)` into two locals, then `root.left = rightResult`, `root.right = leftResult`. Return `root`. If you write `root.left = invert(root.right)` before saving `root.left`, the original left is gone. Swap first then recurse both children is also correct: `root.left, root.right = root.right, root.left` then invert each.

BFS twin: queue the root; for each node, swap its two children and enqueue the (new) children. Same O(n) visits.

Do not return a new tree of copies unless you must — the usual write-up edits in place. Do not stop after swapping only the root.

**Time:** O(n)  
**Space:** O(n) recursion or queue

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

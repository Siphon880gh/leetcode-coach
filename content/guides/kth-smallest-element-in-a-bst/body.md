Given a BST `root` and 1-indexed `k`, return the k-th smallest node value. `[3,1,4,null,2]`, `k = 1` → `1`. `[5,3,6,2,4,null,null,1]`, `k = 3` → `3`. `1 ≤ k ≤ n ≤ 10⁴`.

## Inorder is already sorted; halt at k

Inorder traversal (94) lists every value. Validate BST (98) checks that list strictly increases. Kth Largest in an Array (215) heaps an unordered array — here the tree order is the sort. Flattening all n values then picking index `k − 1` is correct but wastes work when k is small.

Iterative: empty stack, `cur = root`. While `cur` or the stack: if `cur` is present, push it and go left; else pop, `k -= 1`, if `k == 0` return that node’s value, then `cur = popped.right`. Recursion with a shared counter is the same walk. Do not treat k as 0-indexed (`k = 1` is the minimum, not the second). Do not swap left/right (that would be k-th largest).

Follow-up (frequent k-th queries plus inserts): store subtree sizes on each node and branch by left-count versus k in O(height).

**Time:** O(h + k) typical, O(n) worst  
**Space:** O(h) stack

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

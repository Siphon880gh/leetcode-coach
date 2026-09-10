BST `root`, float `target`, integer `k`. Return the **k** node values closest to `target`, any order. The closest set of size `k` is unique. `[4,2,5,1,3]`, target ≈ 3.71, `k = 2` → `[4,3]`. Single node `[1]`, `k = 1` → `[1]`. Up to `10⁴` nodes, `1 ≤ k ≤ n`.

## Inorder is sorted; a window of k consecutive values is enough

Closest Binary Search Tree Value (270) keeps **one** search-path champion. Kth Smallest walks inorder until the k-th. Here you need the k nearest, and they sit together on the sorted inorder line: some consecutive block of length k.

Walk inorder. Keep a deque `q`. While `q` has fewer than k values, push the current. After that, compare `abs(val − target)` to `abs(q[0] − target)` (the left, smallest end of the window). If the new value is **not closer**, every later inorder value is even farther — **return** and skip the right subtree. If it is closer, pop the left of `q` and append this value, then continue.

Do not dump every value into a list and sort by distance (correct but extra work). Do not stop after finding 270’s single closest. Do not keep a size-k heap of random tree order without using sorted inorder (you can, but you lose the prune). Follow-up on a balanced tree: predecessor and successor stacks from the closest node, then walk k steps in O(h + k).

**Time:** O(n) worst (early return often stops before the right tail)  
**Space:** O(k) for the window, plus recursion height

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

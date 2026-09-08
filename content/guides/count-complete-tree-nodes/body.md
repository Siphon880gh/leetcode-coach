Complete binary tree `root`: every level filled except possibly the last, last level packed left. Return the node count. Empty → 0. `[1,2,3,4,5,6]` → 6. `[1]` → 1. Up to `5 × 10⁴` nodes. The follow-up wants better than a full O(n) walk.

## Height of the left spine, then one perfect half

Maximum Depth walks every node. Right Side View keeps one value per level. Naive `1 + count(left) + count(right)` is O(n) and misses the follow-up. Completeness lets you skip a whole perfect subtree.

Height of a subtree here is left-spine length (walk `root.left` until null). Compare `hl = height(root.left)` and `hr = height(root.right)`:

- If `hl == hr`, the left child is a **perfect** tree of height `hl`. Nodes there plus the root: `2^{hl}` (that is `1 << hl`). Recurse only on the right child.
- If `hl > hr`, the right child is perfect of height `hr`. Add `1 << hr` and recurse on the left.

Empty root is 0. Each call spends O(log n) on two spines and drops a perfect half, so O((log n)²). Do not treat a complete tree as always perfect (`2^{h} − 1` on the whole tree). Do not BFS every node.

**Time:** O((log n)²)  
**Space:** O(log n) recursion

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

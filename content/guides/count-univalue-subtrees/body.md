Given a binary tree, return how many **subtrees** have the same value on every node (uni-value). Empty → 0. `[5,1,5,5,5,null,5]` → 4. `[5,5,5,5,5,null,5]` → 6. Up to 1000 nodes.

## Postorder boolean, increment when this whole subtree matches

Same Tree (100) compares two trees. Symmetric Tree (101) is a mirror check. Here you **count** subtrees of one tree. A leaf is a univalue subtree of size 1. A node is univalue only if **both** child subtrees are univalue **and** each existing child equals this node’s value (a missing child is treated as matching).

`dfs(node)` returns whether the subtree is univalue. Null returns true (vacuous) but does **not** increment — the empty tree is 0. Recurse left and right first. If either side is not univalue, return false. If a present child’s value differs from `node.val`, return false. Else increment and return true. `[5,1,5,…]`: the 1-rooted subtree fails (1 ≠ 5) even though its 5-leaves each counted.

Do not count only nodes equal to the global root. Do not skip leaves. Do not increment on null.

**Time:** O(n)  
**Space:** O(h)

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

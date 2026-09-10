Given `root`, collect nodes as if you repeatedly strip every current leaf until the tree is gone. Return a list of those waves. `[1,2,3,4,5]` → `[[4,5,3],[2],[1]]` (any order inside a wave is fine). Single node → `[[1]]`. Up to 100 nodes.

## Post-order height measured from the leaves

A leaf has height 0. An internal node has height `1 + max(left, right)` after both children are done (`null` returns 0). Push `root.val` into `ans[h]`, growing `ans` when `h` is a new wave. Return `h + 1` so the parent sits one wave later.

That one DFS simulates every strip without mutating the tree. Wave 0 is the true leaves, wave 1 is what would be leaves after those are gone, and so on, until the original root.

Do not BFS by depth from the root (level order would put 1 first). Do not loop “find all leaves, delete, repeat” as separate O(n) passes unless the tree is tiny — the height DFS is already O(n). 107 groups by depth from the root (bottom-up levels), a different grouping.

Time: O(n)  
Space: O(n) for the answer (recursion O(height))

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

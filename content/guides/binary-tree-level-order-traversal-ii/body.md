Bottom-up level order, left to right on each row. Up to 2000 nodes.

`[3,9,20,null,null,15,7]` → `[[15,7],[9,20],[3]]`. Single node → `[[1]]`. Empty → `[]`.

## BFS, then reverse the rows

Problem 102 would give `[[3],[9,20],[15,7]]` — root first. Zigzag shuffles left/right inside a row, not the row order. Inorder emits one list. Construct Tree allocates nodes.

If `root` is `None`, return `[]`. Else queue `[root]`. Each round, snapshot `n = len(q)` and collect those values left to right, enqueue existing left then right, then append that row. After all levels, reverse the list of rows so leaves come first — each row stays left-to-right (`[15,7]`, not `[7,15]`). Empty stays `[]`. `[1]` stays `[[1]]`. Return nested lists, not a boolean, a rebuilt tree, or one flat traversal.

**Time:** O(n)  
**Space:** O(n)

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

Return values level by level, left to right. Up to 2000 nodes.

`[3,9,20,null,null,15,7]` → `[[3],[9,20],[15,7]]`. Single node → `[[1]]`. Empty → `[]`.

## BFS one level per snapshot

Inorder mixes levels (`[9,3,15,20,7]`). Same Tree compares two roots. Zigzag Level Order alternates direction. Unique Paths counts grid walks.

If `root` is `None`, return `[]`. Else queue `[root]`. While the queue is nonempty, snapshot `n = len(q)` and process those `n` nodes as one row: pop left, append the value, enqueue existing left then right. Children join during the loop; `n` is the count that belonged to this level only. Then append that row. Return the nested lists — empty is `[]`, not `[[]]`. Not a boolean and not a rebuilt tree.

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

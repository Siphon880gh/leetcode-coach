Perfect binary tree: every parent has two children, all leaves on one level. Set each `next` to the node on its right on the same level; last in a row → `None`. Empty → empty.

`[1,2,3,4,5,6,7]` serializes as `[1,#,2,3,#,4,5,6,7,#]`.

## Link each BFS level

Flatten 114 makes a preorder list on `.right`. Level Order returns nested value lists. Distinct Subsequences counts string ways. Here you keep the tree and fill `.next` across siblings (and across `2 → 3`, `5 → 6`).

If `root` is `None`, return it. Queue `[root]`. Each round, snapshot `n = len(q)` and reset `p = None`. For those `n` nodes: pop left; if `p` exists, `p.next = node`; then `p = node`; enqueue existing left then right. Children join during the row; `n` is only this level, so `2.next` is `3`, not `4`. The last node of a row keeps `next = None` (`#`). Return the same root — not a boolean and not nested integer lists.

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

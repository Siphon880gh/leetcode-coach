Same `next` job as 116, but the tree is **not** perfect: a parent can miss a child, leaves can sit on different depths. Set each `next` to the node on its right on the same level; last in a row → `None`. Empty → empty. Up to 6000 nodes.

`[1,2,3,4,5,null,7]` serializes as `[1,#,2,3,#,4,5,7,#]` — so `5.next` is `7`, not a missing left of `3`.

## Same BFS row as 116

116’s perfect-tree shortcut (`left.next = right`, `right.next = parent.next.left`) fails here: `3.left` is gone, so `5` must skip to `7`. Flatten 114 rewires `.right` in preorder. Level Order returns nested value lists. Distinct Subsequences counts string ways. Here you keep the tree and fill `.next` left to right per level.

If `root` is `None`, return it. Queue `[root]`. Each round, snapshot `n = len(q)` and reset `p = None`. For those `n` nodes: pop left; if `p` exists, `p.next = node`; then `p = node`; enqueue `left` then `right` **only when they exist**. Do not pad dummy nulls — the queue holds only real nodes of this row, so gaps vanish and `5` sits beside `7`. Last in a row keeps `next = None` (`#`). Return the same root — not a boolean and not nested integer lists.

**Time:** O(n)  
**Space:** O(n) for the queue. A follow-up walks each level using the `next` links you just built and threads children with O(1) extra pointers; the BFS above is the same loop as 116 and is enough for the judge.

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

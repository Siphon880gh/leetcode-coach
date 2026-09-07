Zigzag level order — left to right, then right to left, then left to right. Up to 2000 nodes.

`[3,9,20,null,null,15,7]` → `[[3],[20,9],[15,7]]`. Empty → `[]`. Single node → `[[1]]`.

## Reverse every other row

Plain Level Order would emit `[9,20]` on the second row. Zigzag Conversion fills a string by bouncing a row index — not a tree queue. Inorder mixes depths.

Use the same BFS snapshot: if `root` is `None`, return `[]`. Queue `[root]`. `left` starts true. Each round, collect `n` values left to right and enqueue existing left then right (the queue must stay parent order so the next snapshot is still one contiguous level). Then append `t` if `left`, else the reversed row; flip `left`. Do not drain the whole queue into one flat reverse. Return the nested lists.

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

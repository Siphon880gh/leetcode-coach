Binary tree `root`. Values you would see standing on the right, top to bottom. Empty → `[]`. `[1,2,3,null,5,null,4]` → `[1,3,4]`. `[1,2,3,4,null,null,null,5]` → `[1,3,4,5]` — 4 and 5 sit on the left but they are the only nodes at those depths. Up to 100 nodes.

## Rightmost per level, not “always go right”

House Robber was 1D DP. Level Order collected every value on a row. Here you keep **one** value per depth: the rightmost.

BFS: queue the root. Each round, snapshot the queue length as this level. If you enqueue **right then left**, the front of the queue is the rightmost — record it, then drain the level. If you enqueue left then right (Level Order order), record the last node of the snapshot instead. A left-only child still appears when nothing stands to its right at that depth.

DFS twin: visit right, then left. When `depth` equals `len(ans)`, this is the first node you have seen at that depth — append it. Right-first makes that first node the rightmost.

**Time:** O(n)  
**Space:** O(n) for the queue or the recursion stack

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

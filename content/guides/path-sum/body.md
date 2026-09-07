True iff some root-to-leaf path sums to `targetSum`. A leaf has no children. Up to 5000 nodes.

`[5,4,8,11,null,13,4,7,2,null,null,null,1]`, `22` → true. `[1,2,3]`, `5` → false. Empty, `0` → false.

## A root-to-leaf total equals target

Min Depth is a node count. Unique Paths counts grid routes. Path Sum II collects every matching path. Matching a non-leaf prefix can hit the target mid-path and still fail (or succeed later). Empty has no root-to-leaf path.

`dfs(root, 0)`: if `root` is `None`, false. Add `val` to the running sum. If both children are `None` and the sum equals `targetSum`, true. Else return `dfs(left, s)` or `dfs(right, s)`. Return that boolean — not nested lists of paths.

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

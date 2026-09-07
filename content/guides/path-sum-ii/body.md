Return every root-to-leaf path whose values sum to `targetSum`. Up to 5000 nodes.

`[5,4,8,11,null,13,4,7,2,null,null,5,1]`, `22` → `[[5,4,11,2],[5,8,4,5]]`. `[1,2,3]`, `5` → `[]`.

## Collect every matching leaf path

Path Sum I only asks whether one path exists. Unique Paths counts grid routes. Level Order is BFS rows. Flatten rewires pointers. Still only record at a leaf — a prefix that equals the target is not enough.

`dfs`: add `val` to the running sum and `t.append(val)`. If both children are `None` and the sum equals `targetSum`, `ans.append(t[:])` — a copy, because `t` is reused and later `pop()` would mutate a stored path. Recurse both children, then `t.pop()`. Empty or no match → `[]`. Return `ans`, not a boolean.

**Time:** O(n²)  
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

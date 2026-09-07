Maximum depth — nodes on the longest root-to-leaf path. Empty is allowed (0 nodes). Nodes up to 10⁴.

`[3,9,20,null,null,15,7]` → `3`. `[1,null,2]` → `2`.

## 1 plus the deeper child

Level Order returns `[[3],[9,20],[15,7]]`; depth is how many of those rows exist, not the lists. Unique Paths counts grid walks. Counting every node is the size of the tree — five nodes can still have depth 3. Same Tree and Symmetric Tree return booleans.

If `root` is `None`, return `0` so a missing child adds nothing. Else return `1 + max(depth(left), depth(right))`. The current node is on the path; the problem counts nodes, not edges — a single node is `1`, not `0`. Return that integer. Empty tree is `0`, not `[]`.

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

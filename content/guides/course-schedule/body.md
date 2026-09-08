`numCourses` labeled `0 .. numCourses − 1`. `prerequisites[i] = [a, b]` means take `b` before `a`. Return true if you can finish every course. Unique pairs. `[[1,0]]` → true. `[[1,0],[0,1]]` → false.

## Peel in-degree 0; leftover means a cycle

Clone Graph copied an undirected cyclic graph. Number of Islands flooded components. Here the graph is **directed**: can you order the nodes so every edge goes from earlier to later? That is a DAG check.

Build adjacency `g[b].append(a)` and `indeg[a] += 1` (arrow from prereq to dependent). Queue every `i` with `indeg[i] == 0`. While the queue is not empty: pop `i`, decrement the remaining course count, and for each `j` in `g[i]` drop `indeg[j]`; if it hits 0, enqueue `j`. Return whether the remaining count is 0 — every node was taken. A cycle leaves someone with a positive in-degree forever.

Do not reverse the pair: `[a, b]` is not “a before b.” Do not BFS the undirected version; a 2-cycle `0⇄1` is exactly example 2. DFS twin: three colors (unseen / on stack / done); a back edge to the stack is a cycle.

**Time:** O(n + m)  
**Space:** O(n + m)

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

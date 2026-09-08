`numCourses` labeled `0 .. numCourses − 1`. `prerequisites[i] = [a, b]` means take `b` before `a`. Return **any** valid order of all courses, or an empty array if a cycle makes that impossible. Unique pairs. `[[1,0]]` → `[0,1]`. `[[1,0],[2,0],[3,1],[3,2]]` → `[0,2,1,3]` (or `[0,1,2,3]`). One course and no edges → `[0]`.

## Same peel as Course Schedule; keep the list

Course Schedule asked only whether every node can be taken. Here you must **write the order**. Clone Graph copied an undirected cyclic graph. Number of Islands flooded components. This is a directed DAG: every edge should go from earlier in the answer to later.

Build `g[b].append(a)` and `indeg[a] += 1`. Queue every `i` with `indeg[i] == 0`. While the queue is not empty: pop `i`, **append `i` to `ans`**, and for each `j` in `g[i]` drop `indeg[j]`; if it hits 0, enqueue `j`. If `len(ans) == numCourses`, return `ans`. Otherwise some node still has a positive in-degree — a cycle — return `[]`. Do not return a partial prefix.

Do not reverse the pair: `[a, b]` is take `b` first. Do not BFS the undirected version. Do not treat “any order of all n integers” as enough when an edge is violated. DFS twin: three colors; on finish, push the node; reverse the finish stack (or prepend) for a topological order; a back edge to the stack means return empty.

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

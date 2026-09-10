`n` nodes labeled `0 .. n−1`, undirected `edges` `[a, b]`. Return true iff those edges form a **tree**. `n = 5`, `[[0,1],[0,2],[0,3],[1,4]]` → true. Same n with an extra `[1,3]` → false (a cycle). `1 ≤ n ≤ 2000`. No self-loops or duplicate edges.

## Connected and acyclic, not a DAG check

Course Schedule (207) is **directed** (Kahn / leftover nodes). Number of Islands counts grid components. A tree is an undirected graph that is connected and has no cycle. That is the same as: exactly `n − 1` edges **and** one connected component.

Union-find: parent array `p[i] = i`. For each edge, `find(a)` and `find(b)`. If they are equal, the edge closes a cycle → false. Else link one parent to the other and decrement a component counter (start at `n`). After all edges, true iff the counter is `1`. Path compression is enough.

DFS twin: if `len(edges) ≠ n − 1`, false. Build an undirected adjacency list, DFS/BFS from `0`, true iff every node is visited. Do not skip the edge-count (a connected graph with a cycle still visits every node). Do not treat edges as one-way.

**Time:** O(n log n) union-find; O(n) DFS  
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

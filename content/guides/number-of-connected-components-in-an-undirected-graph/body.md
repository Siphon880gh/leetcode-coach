Integer `n` (nodes `0 .. n−1`) and undirected `edges` `[a, b]`. Return how many **connected components**. `n = 5`, `[[0,1],[1,2],[3,4]]` → 2. Same n with a path through all nodes → 1. Isolated vertices count as their own component. No self-loops or duplicate edges. `n` up to 2000.

## Paint from each unvisited start; or merge and count leftovers

Number of Islands (200) floods a **grid**. Graph Valid Tree (261) also needs **one** component and exactly `n − 1` edges. Here you only count pieces. Directed Course Schedule (207) is the wrong graph.

Build an undirected adjacency list. `vis` empty. For each `i`, if not visited, DFS (or BFS) the component and add 1. Isolated nodes never appear in `edges` but still start a DFS that returns 1.

Union-find: parent of each node is itself, `ans = n`. For each edge, `union(a, b)`: if they already share a root, skip; else link and `ans −= 1`. Return `ans`.

Do not treat edges as one-way. Do not forget isolated nodes. Do not require a tree.

**Time:** O(n + m) DFS/BFS; O(n + m α(n)) union-find  
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

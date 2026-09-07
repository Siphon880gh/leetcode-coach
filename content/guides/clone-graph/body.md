Deep-copy a connected undirected graph. Return a new `Node` (the clone of the given start). `[]` → `None`. A lone node clones with empty neighbors. `[[2,4],[1,3],[2,4],[1,3]]` clones 4 nodes with the same edges.

## Map old → new, store before neighbors

A shallow copy still points at the original neighbors. Same Tree is binary. Surrounded Regions walks a grid. Word Ladder is a string graph. The return type is a `Node`, not an adjacency list of ints.

If `node` is `None`, return `None`. If `node` is already in `g`, return `g[node]`. Else create `clone = Node(val)`, set `g[node] = clone`, then append `dfs` of each neighbor. Register the clone **before** walking neighbors: the graph has cycles, and without the map hit, `1→2→1` would call `dfs(1)` again and never return.

Return `dfs(node)` — the new node with val `1` whose neighbor list holds the other clones, not the original pointers. Judges check identity; returning the input is not a deep copy.

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

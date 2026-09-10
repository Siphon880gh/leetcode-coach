`n` nodes labeled `0` … `n−1`, plus `n−1` undirected edges that form a tree. Pick any node as root; height is the longest downward path in edges. Return **every** root that achieves the minimum height (any order). Sample `n = 4`, edges `[[1,0],[1,2],[1,3]]` → `[1]`. Sample `n = 6`, edges `[[3,0],[3,1],[3,2],[3,4],[5,4]]` → `[3,4]`. `n` up to 2×10⁴. `n = 1` → `[0]`.

## Last remaining layer is the center

Height from a leaf is large; height from a middle node is small. The MHT roots are the tree’s **centroids**: always one node, or two adjacent nodes when the diameter is even. Computing height from every candidate is O(n²) and too slow.

Build adjacency lists and `degree[i]`. Put every node with `degree == 1` in a queue. While the queue is non-empty, snapshot this wave’s size, clear `ans`, then for each node in the wave: append it to `ans`, decrement each neighbor’s degree, and enqueue a neighbor when its degree becomes 1. When the queue drains, `ans` holds the last wave — those 1 or 2 nodes are the MHT roots.

Do not DFS or BFS height from every node. Do not return every node that was ever a leaf. Do not treat the graph as directed.

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

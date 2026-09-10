Each equation `Ai / Bi = values[i]` is a directed ratio. Queries ask for `Cj / Dj`. If either name never appeared, or they are not in the same connected component, return `−1`. Same known variable over itself is `1`. Example: `a/b = 2`, `b/c = 3` → `a/c = 6`, `b/a = 0.5`, `a/e = −1`, `a/a = 1`, `x/x = −1` (x never defined). At most 20 equations and 20 queries.

## Store x over its parent; multiply weights while you compress

Treat each variable as a node. `w[x]` means the current value of `x / parent(x)`. On `find(x)`, recurse to the root first, then set parent to that root and multiply `w[x]` by the old parent’s weight so the product still equals `x / root`.

To add `a / b = v`, find roots `pa` and `pb`. If they already match, skip (the input has no contradiction). Else hang `pa` under `pb` and set `w[pa] = w[b] × v / w[a]`. That identity keeps `a / b = v` after both sides are expressed over `pb`. A query `c / d` is `w[c] / w[d]` once both find the same root.

A weighted graph (edge `a → b` with `v` and `b → a` with `1/v`) plus DFS or BFS that multiplies along the path is the same math. Floyd on the small variable set also works.

Number of Islands II (305) is union-find without weights. Course Schedule (207) is directed cycle detection, not ratios. Redundant Connection (684) only cares whether two nodes already share a parent.

Do not return `1` for `x/x` when `x` is absent. Do not treat this as unweighted “are they connected?” — you need the product of edge weights. Do not invert only the last hop and forget earlier hops on the path.

Time: O((E + Q) × α(n)) union-find, or O(Q × (E + n)) DFS  
Space: O(n)

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

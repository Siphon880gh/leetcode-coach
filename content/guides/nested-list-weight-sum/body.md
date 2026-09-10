You get a nested list. Each `NestedInteger` is either one integer or a list of more `NestedInteger`s. The depth of an integer is how many lists enclose it; the input list itself is depth 1. Return the sum of each integer times its depth. `[[1,1],2,[1,1]]` → 10 (four 1s at depth 2, one 2 at depth 1). `[1,[4,[6]]]` → 27. `[0]` → 0. At most 50 top-level items; depth at most 50; values in `[−100, 100]`.

## DFS: add value × depth, or recurse depth + 1

Walk the current list with a `depth` argument starting at 1. If `item.isInteger()`, add `getInteger() × depth`. Else add `dfs(getList(), depth + 1)`. Empty lists add nothing.

BFS twin: queue pairs `(item, depth)`. Integers accumulate; lists enqueue their children at `depth + 1`.

Do not start at depth 0 (that zeros the top level). Do not invert the weights — Nested List Weight Sum II (364) uses `maxDepth + 1 − depth`. Do not flatten first and then multiply by 1 (you would lose nesting). Flatten Nested List Iterator (341) is a cursor, not a weighted sum.

Time: O(N) over every integer and list node  
Space: O(D) recursion or queue (D ≤ 50)

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

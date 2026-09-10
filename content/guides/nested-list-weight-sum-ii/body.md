Same NestedInteger as 339: an integer or a list. Depth is how many lists wrap it (outer list is 1). Let `maxDepth` be the deepest integer. Weight is `maxDepth − depth + 1` (shallow integers weigh more). Return sum of value × weight. `[[1,1],2,[1,1]]` → 8. `[1,[4,[6]]]` → 17. No empty lists. Depth at most 50.

## One DFS: (maxDepth + 1) × s − ws

Weight × value = `(maxDepth + 1) × value − value × depth`. Summing over every integer: `(maxDepth + 1) × s − ws`, where `s` is the sum of values and `ws` is the 339 weighted sum (value × depth).

DFS from depth 1: update `maxDepth`; if integer, add to `s` and `ws`; else recurse at depth+1. You never need a second pass once you have those three numbers.

BFS twin: sum integers per level, then weight level `d` by `maxDepth − d + 1`. Same answer, two conceptual phases.

Do not use raw depth (that is 339: the first example would be 10, not 8). Do not flatten first. Do not invert with `depth / maxDepth` or start depth at 0.

Time: O(N) over every integer and list node  
Space: O(D) recursion or queue (`D ≤ 50`)

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

You get a nested list. Each `NestedInteger` is one integer or a list of more `NestedInteger`s. Implement `NestedIterator`: `next()` returns the next integer in left-to-right order; `hasNext()` is true while any integer remains. `[[1,1],2,[1,1]]` → `[1,1,2,1,1]`. `[1,[4,[6]]]` → `[1,4,6]`. Up to 500 top-level items. Do not implement `NestedInteger` yourself.

## Flatten once, or peel lists in hasNext

Doocs Solution 1: DFS the constructor. If `x.isInteger()`, append `getInteger()`; else recurse into `getList()`. Store a flat array and an index. `hasNext` is index+1 still in range; `next` advances and returns. Empty lists contribute nothing, so they never appear as integers.

Lazy twin: a stack of `NestedInteger`. Push the input reversed so the first element is on top. `hasNext` loops: if the top is an integer, return true; if it is a list, pop it and push its children reversed. Empty lists fall through. `next` is then a guaranteed integer pop.

Do not call `getInteger()` on a list. Do not skip `hasNext` (the tester always calls it before `next`). Do not treat this as Nested List Weight Sum (339) — here you emit values, you do not multiply by depth.

Time: O(N) over every integer and list node (constructor DFS, or amortized across hasNext)  
Space: O(N) for the flat array, or O(D) for the stack in the lazy version

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

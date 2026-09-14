`m` by `n` board of `'X'` (ship) and `'.'` (empty), each side 1 to 200. Ships are a straight 1-by-k row or k-by-1 column. Two ships never share an edge. Return how many ships. The pictured board is 2. `[["."]]` → 0.

## Count heads, not cells

Every ship has exactly one top-left `'X'`: no `'X'` immediately above, and no `'X'` immediately to the left. Walk every cell once; increment when you see that head. Skip `'.'`. Skip an `'X'` that continues a ship from above or from the left.

Number of Islands (200) flood-fills 4-connected land and would also work if you mark visited, but the follow-up asks for one pass, O(1) extra memory, and no writes to `board`. Max Area of Island (695) wants size, not count of disjoint ships.

Do not count every `'X'`. Do not DFS-mutate the board. Do not allow L-shaped ships — the input never has them, and the head rule relies on that.

Time: O(m n)  
Space: O(1)

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

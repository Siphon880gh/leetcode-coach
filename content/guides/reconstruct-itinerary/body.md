Tickets `[from, to]`. Rebuild a trip that uses every ticket exactly once, starting at `JFK`. If several such trips exist, return the one whose airport list is lexicographically smallest. `[["MUC","LHR"],["JFK","MUC"],["SFO","SJC"],["LHR","SFO"]]` → `["JFK","MUC","LHR","SFO","SJC"]`. Second sample: `["JFK","ATL","JFK","SFO","ATL","SFO"]` beats the larger `JFK,SFO,...` route. Up to 300 tickets. At least one valid trip exists.

## Eulerian path, not greedy next-city

This is a directed multigraph (duplicate tickets are extra edges). You need an Eulerian path from `JFK`: every edge once. Hierholzer: from airport `f`, while unused outs remain, pop one destination and recurse; when none remain, append `f`. Reverse the append list to get the path. To prefer lex-small destinations, sort tickets reverse so a stack/list pop yields the smallest unused `to` first.

Greedy “always board the lex-smallest unused flight” can enter a dead end that is not the last unused edge; Hierholzer’s post-order walk backtracks those edges to the end of the itinerary. Do not model this as shortest path or as “visit every airport once” (nodes may repeat; tickets may not).

Time: O(m log m) to sort edges  
Space: O(m)

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

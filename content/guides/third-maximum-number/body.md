Integer array `nums`, length 1 to 1e4, values from −2^31 to 2^31−1. Return the third distinct maximum. If there are fewer than three unique values, return the maximum. `[3,2,1]` → 1. `[1,2]` → 2. `[2,2,3,1]` → 1 (the two 2s count once).

## Three slots; skip a value already stored

Keep `m1 > m2 > m3`, starting at −inf (or a 64-bit sentinel below −2^31). For each `num`: if it already equals a slot, skip. If it is bigger than `m1`, shift `m3 ← m2`, `m2 ← m1`, `m1 ← num`. Else if bigger than `m2`, shift `m3 ← m2`, `m2 ← num`. Else if bigger than `m3`, set `m3`. At the end, if `m3` is still the sentinel, return `m1`; else return `m3`.

A set plus a descending sort also works at this n; the three-slot walk is the O(n) follow-up. Kth Largest Element (215) counts duplicate values as separate ranks. First Missing Positive (41) hunts a missing 1..n, not a ranked max.

Do not treat the two 2s in `[2,2,3,1]` as first and second max. Do not return 2 for `[1,2]` as a missing third. Do not use 32-bit min as the empty sentinel if −2^31 can appear.

Time: O(n)  
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

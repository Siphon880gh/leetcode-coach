`m` by `n` matrix, integer `k`. Return the largest rectangle sum that is still at most `k`. A rectangle that fits is guaranteed. `[[1,0,1],[0,-2,3]]`, `k=2` → 2 (the right 2×2). `[[2,2,-1]]`, `k=3` → 3. `m, n` up to 100. Values can be negative.

## Fix two rows, then 1D max subarray ≤ k

Enumerate top row `i` and bottom row `j`. Maintain `nums[c]` = sum of column `c` from `i` through `j`. That strip is now a 1D array. The rectangle is a contiguous segment of `nums`.

Max subarray sum that is `≤ k`: walk a running prefix `s`. Keep earlier prefixes in a sorted set, seeded with `0`. For each `s`, look up the smallest stored prefix `≥ s − k` (ceiling / lower bound). If it exists, `s − that prefix` is a candidate. Then insert `s`. This is the 1D cousin of 560 (subarray sum equals k) with a ceiling instead of an exact key.

Kadane alone finds the unrestricted maximum; here the cap `k` and negatives mean you need the ordered prefixes. Enumerating every left/right/top/bottom bound is too slow. Follow-up: if rows dwarf columns, enumerate left/right columns instead so the log factor sits on the shorter side.

Time: O(m² n log n) when you enumerate row pairs  
Space: O(n) for the strip and the ordered set

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

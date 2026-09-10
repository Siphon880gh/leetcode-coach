`stones` is a strictly increasing list of positions, `stones[0] = 0`, length 2 to 2000, values up to `2³¹ − 1`. The frog starts on the first stone. The first jump must be exactly 1 unit. After a jump of `k`, the next jump is `k − 1`, `k`, or `k + 1` units, always forward, and must land on a stone. Return whether the last stone is reachable. `[0,1,3,5,6,8,12,17]` is true (jumps 1, 2, 2, 3, 4, 5). `[0,1,2,3,4,8,9,11]` is false: after the early 1-unit steps the gap 4 → 8 is too wide.

## State is (stone index, last jump)

Map each position to its index. `dfs(i, k)` is true if you can finish from stone `i` after arriving with jump `k`. If `i` is the last index, true. Else try `j` in `k−1, k, k+1` with `j > 0`; if `stones[i] + j` is a stone, recurse to that index with last jump `j`. Memoize `(i, k)`.

Start at `dfs(0, 0)`. Then the only legal `j` is 1, which encodes the required first hop. If `stones[1]` is not 1, that hop misses and the answer is false.

Jump Game (55) lets you jump any distance up to `nums[i]`. Jump Game II (45) minimizes hop count on a dense array. Neither tracks a last-step window of three lengths.

Do not allow a 0-length jump. Do not assume every integer between stones is landable. Do not grow `k` without checking the stone set — the 4 → 8 gap fails because you cannot have built a last jump of 4 by then.

Time: O(n²)  
Space: O(n²)

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

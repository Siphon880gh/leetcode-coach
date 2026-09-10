An ugly number is a positive integer whose prime factors are only 2, 3, and 5. Return the **nth** ugly number (`1 ≤ n ≤ 1690`). Sequence starts `1, 2, 3, 4, 5, 6, 8, 9, 10, 12`. `n = 10` → `12`. `n = 1` → `1`.

## Three pointers, min of three candidates

Ugly Number (263) tests one integer by dividing out 2, 3, 5. Here you must **generate** the ordered sequence. Trial-dividing every integer until you have n uglies is too slow at 1690.

`dp[0] = 1`. Indices `p2 = p3 = p5 = 0`. For each next slot, `next2 = dp[p2] × 2`, `next3 = dp[p3] × 3`, `next5 = dp[p5] × 5`. Write `min` of those three. Then increment **every** pointer whose candidate equals that min. `6` is both `2 × 3` and `3 × 2`; bumping only one pointer would duplicate 6. Heap twin: pop the smallest, push `× 2`, `× 3`, `× 5`, with a set so the same value is not pushed twice. DP is O(n); the heap is larger by log.

Do not skip 8 (`2³`). Do not treat this as “is n ugly.” Do not increment only the first matching pointer.

**Time:** O(n) DP; O(n log n) heap  
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

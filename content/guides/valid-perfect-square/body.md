Positive integer `num` (1 .. 2³¹ − 1). Return true iff some integer k satisfies k × k = num. Do not call a language `sqrt`. `16` → true (`4 × 4`). `14` → false.

## Smallest x whose square is at least num

Binary search on `[1, num]`. While `l < r`, take `mid = (l + r) >>> 1`. If the square of mid is already ≥ num, keep the left half (`r = mid`); else `l = mid + 1`. When the loop ends, `l` is the smallest integer with `l × l ≥ num`. True iff that square equals `num`.

Overflow: for `num` near 2³¹ − 1, a 32-bit `mid × mid` wraps. Use a 64-bit product (`1L × mid × mid`) or compare `mid ≥ num / mid` (l starts at 1, so no divide-by-zero). This is not 69: that problem wants the floor of the root; here 14 is false, not 3.

Do not scan `i = 1, 2, …` until `i × i` passes num (too slow at the high end). Newton is fine in an interview but the writeup is this lower-bound search.

Time: O(log num)
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

Return whether integer `n` equals `3ˣ` for some integer `x`. `27` → true (`3³`). `1` → true (`3⁰`). `0` → false. `-1` → false. Range `-2³¹ .. 2³¹ − 1`. Follow-up: no loop, no recursion.

## Divide out 3s, or one max-power modulo

Power of Two (231) is a single 1-bit. Power of Four (342) also needs that bit on an even position. Here the base is 3, so `n AND (n minus 1)` is the wrong test. Floating `log(n) / log(3)` equality rounds.

Loop: while `n > 2`, if `n % 3 != 0` return false, else `n //= 3`. Then true iff `n == 1`. That rejects `0` and negatives (`while` never runs; `n == 1` fails).

No-loop: the largest `3ˣ` that fits in a signed 32-bit int is `3¹⁹ = 1162261467`. Every smaller power of 3 divides that number, and no other positive 32-bit `n` does. So `n > 0` and `1162261467 % n == 0`. Guard `n > 0` before the remainder (modulo 0 is undefined).

Do not treat `-3` as a power. Do not use log rounding. Do not copy the 231 bit mask.

**Time:** O(log n) loop, or O(1) modulo  
**Space:** O(1)

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

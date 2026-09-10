Positive `n` up to `2³¹ − 1`. Even: replace with `n / 2`. Odd: replace with `n + 1` or `n − 1`. Return the fewest replacements to reach `1`. `8` → `3` (`8 → 4 → 2 → 1`). `7` → `4` (`7 → 8 → …` or `7 → 6 → 3 → 2 → 1`). `4` → `2`. `n = 1` is already done (`0` steps).

## Halve evens; on odds, bump when you sit on `11`

Always shift right when the low bit is 0. When odd, look at the last two bits (`n AND 3`). If they are `11` and `n` is not `3`, add 1 (that run of ones becomes a carry you can shift off). Otherwise subtract 1. The `3` exception: `3 → 2 → 1` is two steps; `3 → 4 → 2 → 1` is three.

BFS or memo from `n` also works but must use a 64-bit type if you increment `2³¹ − 1`. The greedy walk is O(log n) steps.

Collatz always does `3n + 1` on odds; here you pick plus or minus one, then only halve. Integer to English (273) is unrelated numbering.

Do not always increment on every odd. Do not increment `3`. Do not overflow a 32-bit signed `n` when you add 1 at the top of the range.

Time: O(log n)  
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

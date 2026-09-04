Reverse the decimal digits of a signed 32-bit `x`. If the reverse would sit outside `[-2³¹, 2³¹ − 1]`, return `0`. The usual interview constraint: you may not stash the answer in a 64-bit integer and clamp afterward.

`123 → 321`, `-123 → -321`, `120 → 21` (leading zeros on the reverse disappear because they are just smaller magnitude).

## Math

Pop the last digit `y` and push it onto `ans`:

`ans = ans * 10 + y`, then drop that digit from `x`.

**Before** multiplying, `ans` must already lie in `[⌊mi/10⌋, ⌊mx/10⌋]` (with `mi = -2³¹`, `mx = 2³¹−1`). If it does not, the next `* 10 + y` cannot fit, so return `0`.

Python’s `%` on negatives is not “last digit” in the C sense; the common fix is to adjust `y` into `[-9, 0]` when `x` is negative, then `x = (x - y) // 10` so truncation matches toward-zero digit peeling.

**Time:** O(log |x|) — one loop per digit  
**Space:** O(1)

## Overflow example

If `ans` is already larger than `⌊mx/10⌋`, even `y = 0` would overflow on `* 10`. Same idea on the negative side with `mi`.

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

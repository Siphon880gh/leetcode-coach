Implement `myAtoi`: turn a string into a signed 32-bit int with a fixed scan, not a language `int()` call.

1. Skip leading spaces.
2. Optional `+` or `-` (default positive). Only one sign character.
3. Read digits until a non-digit or end of string. Leading zeros are just a `0` accumulator. No digits → `0`.
4. If the value would leave `[-2³¹, 2³¹−1]`, **clamp** (unlike Reverse Integer, which returns 0).

`"  -042"` → `-42`. `"1337c0d3"` → `1337`. `"0-1"` → `0` (the `-` after a digit stops conversion).

## Overflow while accumulating

Keep `res` non-negative and apply `sign` at the end. Before `res = res * 10 + c`, if `res` is already past `⌊(2³¹−1)/10⌋`, or equal to it and `c > 7`, you cannot stay in range: return `2³¹−1` when `sign` is positive, else `-2³¹`.

**Time:** O(n)  
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

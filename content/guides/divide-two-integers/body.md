Integer quotient of `dividend / divisor`, truncated toward zero. You may not use `*`, `/`, or `%`. Only 32-bit signed ints: clamp anything above `2^31 - 1` to that max. Divisor is never 0.

`10 / 3` → 3. `7 / -3` → -2.

## Overflow first

`INT_MIN / -1` cannot be represented (it would be `2^31`). Return `2^31 - 1`. `divisor == 1` is just the dividend.

Negating `INT_MIN` overflows if you work in positives, so convert both operands to negative and subtract in that domain (`a <= b` because they are more negative). Restore sign at the end.

## Exponential subtract

While `|a|` still covers a copy of `|b|`, double `x = b` and `cnt` with left shifts until another double would overshoot. Subtract that chunk, add `cnt` to the answer. Inner loop is log of the remaining magnitude.

**Time:** O((log |a|)²)  
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

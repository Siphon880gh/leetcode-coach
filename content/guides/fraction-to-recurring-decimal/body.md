Numerator over denominator as a string. Wrap the repeating fractional digits in parentheses. `1/2` → `0.5`. `2/1` → `2`. `4/333` → `0.(012)`. Numerator 0 → `0`. Finite decimals must stay unwrapped. Answer length under 10⁴.

## Hash remainder to index; a repeat starts the cycle

Language floats lose precision. Compare Version is dotted ints, not division. Always wrapping the whole fraction is wrong: `1/2` has no cycle.

XOR the signs for a leading minus. Use abs as longs so −2³¹ does not overflow. Append `a//b`; `a %= b`. If `a` is 0, return (integer only). Else append a dot. While `a`: `d[a] = len(ans)`; multiply `a` by 10; append `a//b`; `a %= b`; if `a` is already in `d`, insert `(` at `d[a]` and append `)`.

For `4/333`, remainder 4 shows up again after digits 0, 1, 2, so the cycle starts there. Only the repeating run goes in parentheses. `1/2` remainder hits 0 after 5, so `0.5` with no parens. `2/1` remainder 0 after the integer — no decimal point.

**Time:** O(l)  
**Space:** O(l) (answer length)

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

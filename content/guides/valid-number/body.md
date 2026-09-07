Return whether the whole string is a valid number under this grammar. Length ≤ 20. Letters, digits, `+`, `-`, and `.` only.

True: `"0"`, `"4."`, `"-.9"`, `"2e10"`, `"+6e-1"`. False: `"e"`, `"."`, `"1e"`, `"e3"`, `"99e2.5"`, `"1a"`.

## Grammar scan, not language float

Optional leading `+` or `-` (a sign alone is false). Then a significand: at most one `.`, and **at least one digit**. That is why `"4."` and `"-.9"` pass but `"."` and `".e"` fail. Then an optional `e` or `E`, not first and not last: optional sign, then one or more digits. No second dot, no second exponent, no leftover letters.

Language `float` parsers accept inf, hex, and prefixes (`"1a"`). atoi returns a clamped integer, not this boolean. One left-to-right pass with counters for `.` and `e` is enough.

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

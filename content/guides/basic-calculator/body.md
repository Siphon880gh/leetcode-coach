Valid expression `s` of digits, `+`, `-`, `(`, `)`, spaces. No `eval`. Return the integer value. `n ≤ 3 × 10⁵`. `"1 + 1"` → 2. `" 2-1 + 2 "` → 3. `"(1+(4+5+2)-3)+(6+8)"` → 23. Unary `-` is allowed (`"-1"`, `"-(2+3)"`); unary `+` is not. Numbers and the running total fit in 32-bit signed ints.

## Sign times number; parentheses save the outer total

Evaluate Reverse Polish Notation already has operators postfix. Basic Calculator II adds times and divide with no parens. Here only plus/minus and nested parens.

Walk left to right. Hold `ans` and `sign` (1 or −1). Digit: parse the whole integer `x` (`x = x × 10 + digit`), then `ans += sign × x`. `+` sets `sign = 1`. `-` sets `sign = −1`. `(`: push `ans` then `sign`, reset `ans = 0`, `sign = 1` so the inside starts fresh. `)`: pop `sign`, pop outer `ans`: `ans = sign × ans + outer`. Skip spaces.

The stack is LIFO: last pushed is the sign, so pop sign first. Do not `eval`. Do not treat times or divide (that is 227). Do not skip a multi-digit number by reading one character. Unary minus works because after `(` the sign starts at 1 and the next `-` flips it.

**Time:** O(n)  
**Space:** O(n) for nested parens

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

Expression `s` of non-negative integers, `+`, `-`, times, divide, and spaces. No parentheses. Divide truncates toward zero. No `eval`. `"3+2×2"` → 7. `" 3/2 "` → 1. `" 3+5 / 2 "` → 5. `n ≤ 3 × 10⁵`. Intermediate values fit in 32-bit signed ints.

## Previous operator decides how this number joins the stack

Basic Calculator (224) has parens and only plus/minus. RPN is already postfix. Here times and divide bind tighter than plus/minus, with no grouping.

Walk left to right. Hold the last operator `sign` (start as `+`) and the number you are building `v`. Digit: `v = v × 10 + digit`. At an operator or the last character, apply **that previous** `sign` to `v`: plus pushes `v`; minus pushes `−v`; times pops and pushes `pop × v`; divide pops and pushes toward-zero `pop / v`. Then `sign` becomes this operator and `v` resets to 0. Skip spaces (they are not operators). After the scan, return the sum of the stack.

Do not `eval`. Do not treat parens (that is 224). Do not apply the operator you just read to `v` — it belongs to the **next** number. Floor-divide toward negative infinity is wrong for negatives (`int(a / b)` or truncating integer divide toward zero).

**Time:** O(n)  
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

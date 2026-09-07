Evaluate Reverse Polish tokens. Operators are plus, minus, times, and divide. Division truncates toward zero. Valid expression, 32-bit ints. `2 1 + 3 ×` → 9. `4 13 5 / +` → 6.

## Stack: push numbers, pop two on an operator

RPN already encodes order; there are no parentheses to match. Valid Parentheses, Max Points, and Simplify Path are different problems. Max path sum bends at a tree node. RPN is a linear token scan with a stack, not a binary tree walk.

Push numbers. On an operator pop `y` first (top), then `x`. Push `x+y`, `x−y`, `x×y`, or trunc(`x/y`). A lone minus token is the operator; `"-11"` is a number (length greater than 1). After 2, 1, plus, the stack is 3; then times 3 makes 9. The top is the right operand: 13 then 5 then divide is 13/5, not 5/13. Subtraction and division are not commutative.

Python `int(truediv)` or C++ toward-zero int divide: 13/5 is 2, and 6/-132 is 0, which is why the long sample ends at 22. Return the one remaining stack value. `4 13 5 / +` is 6 — 13/5 truncates to 2, then 4+2.

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

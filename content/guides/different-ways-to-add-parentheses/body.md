Expression of digits and the operators plus, minus, and times. Return every value you can get by fully parenthesizing, any order. Length at most 20. `"2-1-1"` → `[0, 2]` because `((2-1)-1)` and `(2-(1-1))`. `"2×3-4×5"` → `[-34, -14, -10, -10, 10]`.

## Split at an operator, memoize the substring

Generate Parentheses builds strings of `()`. Unique Binary Search Trees **counts** Catalan trees. Basic Calculator / II evaluate **one** precedence. Here you need **all** association trees, and the values, not the parenthesized strings.

`dfs(exp)`: if `exp` is all digits, return `[int(exp)]`. Otherwise scan every operator at index `i`. Recurse on `exp[:i]` and `exp[i+1:]`. For each left value `a` and right value `b`, append `a` plus `b`, `a` minus `b`, or `a` times `b` according to that operator. Memoize on the substring (or on `(l, r)` index bounds) so the same piece is not re-split. Two-digit numbers exist (`0`..`99`), so a digit check on the whole slice is safer than “length less than 3”.

Do not apply left-to-right only. Do not drop duplicate values: the sample keeps two `-10`s. Do not invent operator precedence; parentheses decide everything.

**Time:** exponential in the number of operators, cut by memoization (output up to `10⁴` values)  
**Space:** O(output) plus recursion / memo

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

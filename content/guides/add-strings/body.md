Two non-negative integers as digit strings `num1` and `num2`, each length 1 to 1e4, no leading zeros except `"0"`. Return their sum as a string. Do not parse the whole string into a language integer or BigInt. `"11"` + `"123"` → `"134"`. `"456"` + `"77"` → `"533"`. `"0"` + `"0"` → `"0"`.

## Right to left; leftover carry is a new digit

Point `i` and `j` at the last characters. While either index is still in range or carry is nonzero: missing digits count as 0. Sum `a + b + carry`, append the ones digit (`sum % 10`), set carry to the tens digit (`sum / 10` as integer). After both strings are exhausted, a leftover carry of 1 becomes an extra leading `"1"` ( `"9"` + `"1"` → `"10"` ). Digits were appended least-significant first, so reverse (or build a deque from the front) before joining.

Add Two Numbers (2) walks linked-list digits, not strings. Add Binary (67) uses base 2. Do not `int(num1)` when length is 1e4.

Do not add from the left. Do not drop the final carry. Do not keep leading zeros in the answer except for `"0"` itself.

Time: O(max(m, n))  
Space: O(1) besides the answer

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

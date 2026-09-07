`num1` and `num2` are non-negative integers as digit strings (no leading zeros except `"0"`). Return their product as a string. Do not parse the whole input as a machine int and do not call a BigInteger library. Lengths up to 200.

`"2"` × `"3"` → `"6"`. `"123"` × `"456"` → `"56088"`.

## Grade-school into m+n slots

The product has at most `m + n` digits. Allocate `arr[0 .. m+n-1]` as those positions, index 0 the most significant.

Digit `num1[i]` times digit `num2[j]` belongs at place `i + j + 1` (the extra `+1` leaves `arr[0]` for a possible carry-out). Add `a × b` into that slot for every pair `(i, j)` from the right.

Then walk from the least significant end: `arr[k-1] += arr[k] // 10`, `arr[k] %= 10`. Drop a leading zero if `arr[0]` stayed 0. If either input is `"0"`, return `"0"` before the loops.

You only ever convert **one** character to 0–9. That is allowed; converting the whole string to an int is not.

**Time:** O(m × n)  
**Space:** O(m + n)

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

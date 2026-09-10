Digit string `num`. True iff you can split it into **at least three** numbers where each after the first two is the sum of the previous two. No leading zeros (`1, 02, 3` is invalid; a lone `0` is fine). `"112358"` → true (`1,1,2,3,5,8`). `"199100199"` → true (`1,99,100,199`). Length 1 to 35.

## First two cuts, then the sum is forced

Fibonacci Number (509) asks F(n). Split Array into Fibonacci Sequence (842) returns one list. Here you only need yes/no, but the same search: the first two lengths are free; after that the next number is determined.

Enumerate end of first number `i` and end of second `j` (both at least 1, leftover at least 1 so a third number can exist). Reject a multi-digit chunk that starts with `0`. Then `dfs(a, b, rest)`: empty rest → true (you already placed three or more). Else the next chunk must equal `a + b` as an integer, match a prefix of `rest`, and have no leading zero unless the sum is 0. Recurse `dfs(b, a+b, rest after that prefix)`. Overflow follow-up: add digit strings instead of 64-bit ints (n = 35 can exceed `long`).

Do not allow `03`. Do not accept a split with only two numbers. Do not treat this as “is `num` a Fibonacci number.”

**Time:** exponential in n, n ≤ 35, with tight first-two loops  
**Space:** O(n) recursion

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

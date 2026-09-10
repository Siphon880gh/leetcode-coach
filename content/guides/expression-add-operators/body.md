Digit string `num`, integer `target`. Insert binary plus, minus, or times between digits (operands may span several digits) so the expression equals `target`. No leading zeros (`105` to `5` allows `1×0+5` and `10−5`, not `1×05`). `"123"`, target `6` → `1×2×3` and `1+2+3`. `"232"`, target `8` → `2×3+2` and `2+3×2`. Length 1..10.

## Last operand is the times hook

Basic Calculator II applies plus/minus/times with a stack. Different Ways to Add Parentheses splits at every operator. Here you **choose** the operators. Times binds tighter than plus/minus, so you cannot only keep a running total.

`dfs(u, last, curr, path)`: `u` is the next unused index. If `u` is the end and `curr == target`, record `path`. For each end `i` from `u` onward, take operand `next = int(num[u .. i])`. If `num[u]` is `0` and `i > u`, stop (no leading zeros). First operand (`u == 0`): recurse with `last = next`, `curr = next`. Else three branches:

- Plus: `curr + next`, new last `next`
- Minus: `curr − next`, new last `−next`
- Times: undo the last addend, then attach the product: `curr − last + last × next`, new last `last × next`

Use 64-bit integers for `next` / `curr`. Do not `eval` finished strings. Do not skip the times undo (otherwise `2+3×2` is computed as `(2+3)×2`). Do not emit `05`.

**Time:** exponential in n (n ≤ 10)  
**Space:** O(n) recursion and path

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

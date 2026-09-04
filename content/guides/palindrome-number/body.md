Return whether integer `x` reads the same forward and backward. Follow-up: **no string**.

`-121` is not a palindrome (the minus sign only appears on the left). `10` reverses to `01`, which is not `10`.

## Reverse half the digits

Reject `x < 0`. Also reject any positive `x` whose last digit is `0` (it would need a leading zero). `0` itself is a palindrome (`x and x % 10 == 0` is false when `x` is 0).

Build `y` by repeatedly taking `x % 10` and doing `y = y * 10 + digit`, while shrinking `x` with `x //= 10`, until `y >= x`. You have then reversed the **right half**.

- Even length: `x == y` (`1221` → left `12`, reversed right `12`)
- Odd length: the middle digit sits on `y`, so compare `x == y // 10` (`121` → `x` is `1`, `y` is `12`)

**Time:** O(log₁₀ |x|)  
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

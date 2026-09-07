Compute `x` to the power `n` (integer `n`, including negative). Do not call the language `pow`. n can be −2³¹, so negate it in a wider integer.

`2.0`¹⁰ → `1024`. `2.0`⁻² → `0.25`.

## Binary exponentiation

`n` in binary is a sum of powers of two. `x^n` is the product of `x^(2^k)` for each set bit.

Iterative: `ans = 1`, `a = x`, `e = |n|`. While `e > 0`:

- If `e` is odd, `ans = ans × a`
- `a = a × a`
- `e >>= 1`

If `n < 0`, return `1 / ans`. If `n == 0`, the loop never runs and you return 1.

A recursive `myPow(x, n/2)` squared (and one extra `× x` when odd) is the same tree. Multiplying `x` in a loop `n` times is O(|n|) and too slow at 2³¹.

**Time:** O(log |n|)  
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

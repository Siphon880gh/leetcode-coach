Positive integer `a` (up to 2³¹ − 1) and digit array `b` (length 1..2000, no leading zeros). Return `a^b mod 1337`. `a = 2`, `b = [3]` → `8`. `a = 2`, `b = [1,0]` → `1024`. `a = 1` with a huge `b` → `1`.

## Last digit first: consume d, then raise the base to 10

You cannot join `b` into a machine int. If `b = […, d1, d0]`, then `a^b = a^d0 × (a^10)^d1 × (a^100)^d2 × …`. Walk `b` from the right: multiply `ans` by `pow(a, d, 1337)`, then replace `a` with `pow(a, 10, 1337)`. Each `pow` is binary exponentiation: square the base, multiply into the answer when the exponent’s low bit is set, always mod 1337.

Pow(x, n) (50) is a float base and a 32-bit exponent, no modulus. Here the exponent is a digit list and the modulus is 1337 (`7 × 191`). Euler’s totient `φ(1337) = 1140` can shrink the exponent when `gcd(a, 1337) = 1`; the digit walk does not need that.

Do not loop `a` times `b` as an integer. Do not skip the mod on the running `a^10`. A leftover `ans = 1` with `a` never updated fails `[1,0]`.

Time: O(len(b) log 10) binary-exp steps
Space: O(1)

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

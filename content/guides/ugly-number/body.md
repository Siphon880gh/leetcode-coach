An **ugly number** is a positive integer whose prime factors are only 2, 3, and 5. Return whether `n` is ugly. Range includes negatives and 0. `6` → true (`2 × 3`). `1` → true (no prime factors). `14` → false (factor 7).

## Strip 2, 3, 5; leftover must be 1

Power of Two keeps dividing by 2 (or checks one set bit). Count Primes sieves every integer up to `n`. Happy Number walks digit squares. Ugly Number II asks for the nth ugly value. Here you only test one integer.

If `n < 1`, false (`0` and negatives are not positive). For each of 2, 3, 5, while `n % x == 0`, set `n = n / x`. Then `n == 1`. `6` becomes 1. `14` sticks at 7. `1` never enters the loops and stays 1. Do not trial-divide by every prime. Do not treat `8` as false (it is `2³`). Do not skip the `n < 1` check.

**Time:** O(log n) divisions  
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

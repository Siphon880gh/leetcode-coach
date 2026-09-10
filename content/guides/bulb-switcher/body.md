`n` bulbs start **off**. Round `i` (1..n) toggles every `i`-th bulb. Return how many are **on** after `n` rounds. `n = 3` → 1 (only bulb 1 stays on). `n = 0` → 0. `n = 1` → 1. Constraint: `n` up to `10^9`, so simulating rounds is too slow.

## Odd divisor count; only squares

Bulb `k` is toggled once for each divisor of `k`. Divisors pair as `d` and `k/d`. That count is even unless some `d` equals `k/d`, i.e. `k` is a perfect square — then the square-root divisor is counted once and the total is odd. Odd toggles from off means **on**.

So the answer is how many perfect squares sit in `1..n`, which is `floor(sqrt(n))`. `12` has six divisors (off). `16` has five (on). Do not simulate a boolean array of size `n`. Do not confuse this with Bulb Switcher II / III / IV (flips of a subset, or a different cost).

**Time:** O(1)  
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

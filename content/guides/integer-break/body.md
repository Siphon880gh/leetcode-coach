Integer `n` from 2 to 58. Break it into `k ≥ 2` positive integers that sum to `n`, and maximize their product. `n = 2` → `1` (`1+1`). `n = 10` → `36` (`3+3+4`).

## Break into 3s; leftover 1 is poison

Among integers, 3 is the best factor (2 is close; 4 = `2+2` with the same product; 5 and up should be split further). Because `k ≥ 2`, you cannot return `n` itself: `n = 2` and `n = 3` are `n − 1`.

For `n ≥ 4`, use as many 3s as possible:

- Remainder 0: product is `3` to the `(n / 3)`.
- Remainder 2: one extra 2.
- Remainder 1: do not keep a 3 and a 1 (`3 × 1 = 3`). Pull one 3 back and write `2+2` (`3^(n/3 − 1) × 4`). Example: 10 = `3+3+4`.

DP twin: `f[i]` = best product after splitting `i`. For each last part `j` in `1 .. i−1`, take `max(j × (i − j), j × f[i − j])`. The unsplit remainder is required because `f[i − j]` already assumed a further split.

Do not skip the split (returning `n`). Do not leave a leftover 1. Do not treat this as Integer Break II (343 is the product; there is no “count ways” version here).

Time: O(1) math, or O(n²) DP  
Space: O(1) math, or O(n) DP

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

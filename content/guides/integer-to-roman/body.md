Map `1..3999` to Roman by walking a fixed table from largest to smallest: `M` 1000, `CM` 900, `D` 500, `CD` 400, `C` 100, `XC` 90, `L` 50, `XL` 40, `X` 10, `IX` 9, `V` 5, `IV` 4, `I` 1. Subtractive pairs sit in the table so you never emit four of the same power-of-ten symbol.

`1994` → `MCMXCIV` (1000, then 900, 90, 4). Place value matters: `49` is `XLIX`, not `IL`.

## Greedy table

For each pair `(symbol, value)` in that order, while `num >= value`, append the symbol and subtract. Because every leftover is smaller than the current value, the greedy choice is unique for this range.

**Time:** O(1) — at most a handful of appends (13 table rows, `num` ≤ 3999)  
**Space:** O(1) extra besides the output string

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

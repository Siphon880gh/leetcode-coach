Build an `n × n` matrix filled with `1 .. n²` in clockwise spiral order. n ≤ 20.

`n = 3` → `[[1,2,3],[8,9,4],[7,6,5]]`. `n = 1` → `[[1]]`.

## Fill 1 to n², turn on occupied

Same heading as Spiral Matrix I: `dirs = (0, 1, 0, -1, 0)` for right, down, left, up. Start from zeros. For `v` from 1 to `n²`: write `v` at `(i, j)`, peek the next cell. If that peek is out of bounds or already nonzero, rotate `k = (k + 1) % 4`. Then step.

Zeros mean empty, so a filled cell is its own `vis` flag — no second grid. Spiral Matrix I **reads** an existing board into a list; here the board is the answer. Filling 1..n² in row-major order and then reading it with I does not produce the n=3 picture (center should be 9, bottom-right 5). Rotate Image turns a square you already have; it does not place the sequence.

**Time:** O(n²) — every cell is written once  
**Space:** O(1) besides the answer matrix

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

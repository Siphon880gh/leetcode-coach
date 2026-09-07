Return **how many** distinct n-queen boards exist. Do not return the boards. n ≤ 9.

`n = 4` → 2. `n = 1` → 1.

## Count placements, skip the board

Reuse N-Queens: `dfs(i)` places one queen in row `i`. Block `col[j]`, `diag[i+j]`, `anti[n-i+j]` (or `i-j+n`). Recurse, then unmark.

When `i == n`, do `ans += 1` and return. You never need a `g[][]` of `Q` / `.`. That drops the O(n²) copy at each leaf.

Bitmasks (`cols`, `diag`, `anti` as integers, try the lowest free bit) are the same tree with cheaper mark/unmark. Building every board from problem 51 and taking `len` works but wastes memory.

**Time:** O(n!)  
**Space:** O(n)

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

`m` by `n` matrix of characters `'0'` / `'1'`. Black pixels form **one** 4-connected component. You are given one black cell `(x, y)` (`x` is the row). Return the **area** of the smallest axis-aligned rectangle that covers every `'1'`. Sample with a seed at `(0, 2)` → 6. `[["1"]]` → 1. Must run faster than a full `m` by `n` scan.

## Search the four sides, do not flood the blob

Number of Islands paints every land cell. Maximal Square DP-s every cell. Here the spec forbids O(m n): a BFS/DFS from `(x, y)` that tracks min/max row and column is correct but too slow on the letter of the problem.

A row (or column) is “black” if it contains at least one `'1'`. Because there is a single connected blob and `(x, y)` is inside it, every black row lies in a contiguous band that includes row `x`, and every black column lies in a band that includes `y`.

Binary-search the **top** edge in `[0, x]`: mid row has a `'1'` → search lower rows; else search toward `x`. Binary-search the **bottom** edge in `[x, m−1]` with an upper-bound (right-biased) mid so you keep a black row. Same pair of searches on columns using `y`. Checking whether a row is black scans that row (O(n)); a column scan is O(m). Area = `(bottom − top + 1) × (right − left + 1)`. Cells are characters — compare to `'1'`.

Do not flood-fill. Do not return width or height alone. Do not assume integer 0/1.

**Time:** O(m log n + n log m)  
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

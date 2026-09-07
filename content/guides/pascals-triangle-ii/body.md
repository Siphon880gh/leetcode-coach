Return the 0-indexed `rowIndex`-th row of Pascal’s triangle — one list, not the whole triangle. `rowIndex` is 0..33. Follow-up: extra space linear in the row.

`3` → `[1,3,3,1]`. `0` → `[1]`, not `[[1]]`. `1` → `[1,1]`.

## Grow one array from the right

Pascal I returns nested rows `[[1],[1,1],…]`. Unique Paths returns one integer. Distinct Subsequences counts string ways. Next Right II mutates tree `.next`. Here you need a single row and can reuse O(n) space.

Seed `f` with `rowIndex + 1` ones. For `i` from 2 through `rowIndex`: walk `j` from `i - 1` down to 1 and do `f[j] += f[j - 1]`. Ends stay 1 because you never write `f[0]`. Scan right to left so `f[j]` still holds the previous row until you overwrite it. Left to right, `f[1]` becomes `1+1=2` and then `f[2]` uses that 2 instead of the old 1 — the row is wrong.

Return `f` — `[1,3,3,1]`, not Pascal I’s `[[1],[1,1],[1,2,1],[1,3,3,1]]`.

**Time:** O(n²)  
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

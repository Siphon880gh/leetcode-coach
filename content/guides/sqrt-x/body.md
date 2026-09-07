Floor of the square root of a non-negative integer `x` (x up to 2³¹ − 1). Do not use a language `sqrt`, `pow`, or `** 0.5`.

`4` → 2. `8` → 2 (2.828… rounded down).

## Binary search, compare with divide

Search the largest integer `mid` with `mid × mid ≤ x` on `[0, x]`. Mid is biased up: `mid = (l + r + 1) >> 1`. If `mid > x // mid`, the square is too big — `r = mid - 1`. Else `l = mid`. When the loop ends, return `l`.

Compare with divide, not `mid × mid > x`: for x near 2³¹ − 1 that product wraps a 32-bit int. The `+1` bias plus `l = mid` avoids stalling when `l + 1 == r`. A linear scan `i × i` until it exceeds x is O(√x) and is not the writeup. This is not Pow(x, n).

**Time:** O(log x)  
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

Capture every `O`-region that does **not** touch the border: flip those `O`s to `X`, in place. An `O` on the edge stays. Up to 200×200, cells are `X` or `O`.

Sample: inner `O`s become `X`; the bottom-edge `O` remains. `[["X"]]` stays `[["X"]]`.

## Mark from the rim, then flip leftovers

Flipping every `O` would capture the border too. Number of Islands counts components. Word Search hunts a string. Set Matrix Zeroes marks rows. Word Ladder is a letter-swap graph. You must edit the same board; do not return a copy.

DFS from every border `O`. Walk only cells that are still `O`, paint them `.`, recurse four ways. After that pass: `.` → `O` (unsurrounded) and leftover `O` → `X` (captured). Anything that can reach the edge is not surrounded; the interior leftover is exactly the captured set. Starting DFS on every interior `O` and aborting if you hit the rim can work, but you must not flip a region that later touches the border — marking from the rim first is the safe one-pass capture.

The function is void. Mutate `board`. Return nothing — not an island count, not a copied grid.

**Time:** O(m · n)  
**Space:** O(m · n) for the call stack in the worst case

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

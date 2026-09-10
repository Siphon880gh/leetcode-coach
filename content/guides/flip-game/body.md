String `currentState` of `+` and `-`, length 1..500. A move flips two consecutive `++` into `--`. Return **every** string after exactly one valid move, any order. No move → `[]`. `"++++"` → `"--++"`, `"+--+"`, `"++--"`. `"+"` → `[]`.

## One scan of adjacent pairs; Flip Game II is a different problem

Flip Game II (294) asks whether the first player can force a win by choosing among these moves. Nim Game (292) is a different impartial game. Here you only list the children of the current state.

Walk `i` from 0 to `n − 2`. If `s[i]` and `s[i + 1]` are both `+`, set both to `-`, append a copy of the string, then set them back to `+`. Overlapping pairs both count: in `"++++"` the windows at 0, 1, and 2 each fire. A `+-` or `--` window is not a move.

Do not recurse. Do not flip non-adjacent pluses. Do not forget to restore (the next window must see the original string).

**Time:** O(n²) (n windows, each copy costs O(n))  
**Space:** O(n) besides the answer list

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

String `currentState` of `+` and `-`, length 1..60, at most 20 consecutive pluses. Players alternate flipping two consecutive `++` into `--`. No legal move loses. True iff the starting player can force a win. `"++++"` → true (flip the middle pair to `"+--+"`). `"+"` → false.

## Flip Game lists children; here you search for a losing reply

Flip Game (293) returns every one-move string. Nim Game (292) is a different heap. Here you recurse: from the current board, you win if **there exists** a move whose resulting board is a loss for the opponent.

Encode pluses as bits of `mask` (bit `i` set iff `s[i]` is `+`). `dfs(mask)`: for each `i` where bits `i` and `i + 1` are both set, clear those two bits (XOR) and call `dfs`. If that call is false, return true. If every child is true (or there is no move), return false. Cache `mask` so the same board is not searched twice.

Do not stop after listing one layer of Flip Game moves. Do not assume an odd number of `++` windows wins (overlapping windows share pluses). Do not skip the memo — n can be 60.

**Time:** exponential in the number of pluses, cut by the 20-in-a-row cap and the cache  
**Space:** O(states cached) plus recursion depth

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

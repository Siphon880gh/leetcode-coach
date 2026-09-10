n×n board, `n` from 2 to 100. Two players (ids 1 and 2) alternate. `move(row, col, player)` is always a valid empty cell; cells are unique. Return `0` if nobody has won yet, else the winner’s id. A win is `n` of that player’s marks in one row, one column, or one of the two main diagonals. At most `n²` moves. Follow-up: better than scanning the whole board each move.

## Count the affected lines only

Keep, per player, a count for each of the `n` rows, `n` columns, the main diagonal (`row == col`), and the anti-diagonal (`row + col == n − 1`). On a move, increment those (at most four) counters. If any equals `n`, return `player`; else `0`.

A signed trick uses one array: player 1 adds `+1`, player 2 adds `−1`; a line wins when its absolute value is `n`.

Do not walk all `n²` cells after every move. Do not increment both diagonals on every cell. Do not wait for a draw check — the problem only asks for a winner after a valid move. Find Winner on a Tic Tac Toe Game (1275) is the same counting idea on a fixed 3×3 with a move list. Valid Tic-Tac-Toe State (794) asks whether a board could arise, not who just won.

Time: O(1) per `move`  
Space: O(n)

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

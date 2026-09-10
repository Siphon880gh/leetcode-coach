`SnakeGame(width, height, food)` then `move(U|D|L|R)` returning the score, or −1 if the snake hits a wall or its own body. Start at `(0, 0)` with length 1. Food appears in order: the next `food[i]` only after the previous is eaten. Eating grows length and score by 1. Example on a 3×2 board with food `(1,2)` then `(0,1)`: `R, D, R, U, L, U` → `0, 0, 1, 1, 2, −1`. Up to 10^4 moves; width and height up to 10^4.

## Queue plus set; remove the tail before the bite check

Store the body as a deque (head at the front) and a set of occupied cells. Encode a cell as `row × width + col` so you never allocate a `height × width` board.

Compute the new head. Out of bounds → −1. If it matches the current food, keep the tail (grow) and advance the food index. Otherwise pop the tail from the deque and the set. Then, if the new head is still in the set, the snake bit itself → −1. Else push the head.

The tail-first order matters: sliding into the cell the tail is leaving is legal. Do not test self-collision before dropping that tail. Do not spawn every food at once. Do not grow on empty cells.

Time: O(1) per move  
Space: O(length of snake)

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

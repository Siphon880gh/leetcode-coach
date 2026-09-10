Jugs hold `x` and `y` liters. Infinite tap. You may fill a jug, empty a jug, or pour from one into the other until the source is empty or the dest is full. True if some reachable state has `target` liters in one jug or in both combined. `x = 3, y = 5, target = 4` → true (Die Hard). `2, 6, 5` → false. `1, 2, 3` → true (fill both). Capacities and target up to 1000.

## Bézout: multiples of gcd, up to x + y

Every pour changes the amounts by ±x or ±y, so every reachable total is a multiple of `gcd(x, y)`. You cannot hold more than `x + y`. So:

- `target = 0` → true (start empty).
- `target > x + y` → false.
- else true iff `target` mod `gcd(x, y)` is 0.

That is Bézout's identity on two jugs. `2` and `6` only make even totals, so 5 is impossible.

Doocs Solution 1 DFS: state `(i, j)` = current liters. Seen set. Success if `i`, `j`, or `i + j` equals target. Recurse fill/empty/pour. Time and space O(x + y) states. Same yes/no as the gcd test; use gcd when you only need feasibility.

Do not require the target to sit in one jug only if the problem allows the combined total (example 3). Do not BFS every milliliter as a separate graph node beyond the two jug amounts. Do not assume filling the larger jug once is enough.

Time: O(log(max(x, y))) gcd, or O(x + y) DFS  
Space: O(1) gcd, or O(x + y) visited states

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

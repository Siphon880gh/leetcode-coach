LIFO stack (`push`, `pop`, `top`, `empty`) using **only** queue ops: enqueue back, dequeue/peek front, size, empty. At most 100 calls. Sample: push 1, push 2, `top` → 2, `pop` → 2, `empty` → false. Follow-up: one queue.

## Rotate so the newest is at the front

Min Stack is a real stack plus running mins. Implement Queue using Stacks (232) is the opposite adapter. A queue alone is FIFO, so a naive enqueue makes `pop` take the oldest. You must pay on `push` (or on `pop`) to reverse the order.

Two queues: enqueue `x` into an empty `q2`, then dequeue everything from `q1` into `q2`, then swap names. `q1`’s front is now `x`. `pop` / `top` are `q1`’s front. `empty` is `q1` empty.

One-queue twin: enqueue `x`, then dequeue-and-enqueue `size − 1` times so the previous front values rotate behind `x`. Same front-is-top invariant. `push` is O(n); the other ops are O(1). Do not peek or pop the back (that is a deque, not a queue). Do not use a language list as a stack.

**Time:** O(n) `push`, O(1) `pop` / `top` / `empty`  
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

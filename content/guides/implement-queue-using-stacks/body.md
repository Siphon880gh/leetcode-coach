FIFO queue (`push` back, `pop` / `peek` front, `empty`) using **only** stack ops: push top, pop/peek top, size, empty. At most 100 calls. Sample: push 1, push 2, `peek` → 1, `pop` → 1, `empty` → false. Follow-up: amortized O(1) per op.

## Two stacks: in for push, out for the front

Implement Stack using Queues (225) is the opposite adapter (LIFO from FIFO). Min Stack keeps running mins. One stack alone is LIFO, so a naive push makes `pop` take the newest. You reverse once by pouring.

`in` receives every `push` (O(1)). `pop` / `peek`: if `out` is empty, while `in` is nonempty pop `in` and push `out` — the oldest value is now `out`’s top. Then pop or peek `out`. Do not pour when `out` still holds values (that would scramble a later front). `empty` is both stacks empty. Each value moves from `in` to `out` at most once, so n ops cost O(n) total.

Do not pop the bottom of a list (that is a deque). Do not use 225’s rotate-on-every-push here: that builds a stack, not a queue.

**Time:** O(1) `push` / `empty`; amortized O(1) `pop` / `peek`  
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

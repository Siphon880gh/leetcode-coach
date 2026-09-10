Slots `0 .. maxNumbers−1` (`maxNumbers` up to 1e4). `get()` assigns any unused number, or `−1` if none are left. `check(number)` is true iff that slot is still free. `release(number)` returns a slot to the pool. Example with 3 slots: `get, get, check(2)` → some two numbers assigned, 2 still free; next `get` takes 2; `check(2)` is false; `release(2)` then `check(2)` is true. At most about 2×10^4 mixed calls.

## Hash set (or queue) of unused ids

Put every id in a set `available`. `get` pops any element (Python `set.pop`, or take the head of a queue if you prefer a stable order). Empty set → `−1`. `check` is `number in available`. `release` adds `number` back; adding a slot that is already free is a no-op.

A boolean array plus a free-list queue is the same idea: `get` dequeues, `release` enqueues only if the slot was taken. Scanning `0 .. n−1` on every `get` is too slow once n is 1e4 and you have 2e4 calls.

Insert Delete GetRandom (380) tracks the used set with O(1) random among members. LRU Cache (146) evicts by recency. Neither is a pool of integer slots.

Do not hand out a number that is still in `available`. Do not skip `release` of an already-free number (it must stay a no-op, not crash). `get` may return any remaining id, not necessarily the smallest.

Time: O(1) per get / check / release
Space: O(maxNumbers)

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

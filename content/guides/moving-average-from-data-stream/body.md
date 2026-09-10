Stream of integers, window size `size` (1..1000). `MovingAverage(size)` then `next(val)` returns the mean of the last `min(count, size)` values as a float. At most 1e4 calls. Size 3: `1` → `1.0`; `10` → `5.5`; `3` → about `4.66667`; `5` → `6.0` (the first 1 has left).

## Running sum; drop the outgoing slot

Keep `s` = sum of values currently in the window. A queue of length at most `size`: if the queue is already full, subtract the front and pop it; then push `val` and add it to `s`. Return `s / queue.length` (not always `size` — the window starts short).

Circular array of length `size`: `i = cnt % size`. `s += val − data[i]` (the old occupant is 0 until that slot has wrapped), store `val`, `cnt += 1`, return `s / min(cnt, size)`.

Do not re-sum the whole window each call. Do not divide by `size` while fewer than `size` values have arrived. This is not Sliding Window Maximum (239) or Median (480).

Time: O(1) per `next`  
Space: O(size)

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

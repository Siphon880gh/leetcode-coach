Window of length `k` slides from left to right. For every position, report the max of the `k` values you can see. `[1,3,-1,-3,5,3,6,7]`, `k = 3` → `[3,3,5,5,6,7]`. `n` up to `10⁵`, so a nested max over each window is O(n k) and times out. Follow-up: better than a heap of size `k`.

## Decreasing deque of indices

Minimum Size Subarray Sum grows and shrinks a sum. Here the window **size is fixed**; you need the max, not a sum. A max-heap of `(value, index)` works: push `i`, pop the top while its index is `≤ i − k`, then the top value is the answer. That is O(n log n). Lazy deletes leave stale entries; only the current top needs to be in-window.

The O(n) structure is a deque of **indices**, front to back **decreasing** in `nums`. For each `i`:

1. If the front index is `≤ i − k`, drop it (it left the window).
2. While the back index has `nums[back] ≤ nums[i]`, pop the back (it can never be max after `i`).
3. Push `i`.
4. If `i ≥ k − 1`, append `nums[front]` to the answer.

Front is always the max of the current window. Equals get popped from the back too, so the deque stays strictly decreasing. Store indices, not values: you need them to know when a candidate leaves. Do not emit until the first window is full (`i` from `k−1` onward). One pass; each index is pushed and popped at most once.

**Time:** O(n) deque; O(n log n) heap  
**Space:** O(k)

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

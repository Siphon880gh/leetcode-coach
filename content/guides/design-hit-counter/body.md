Count hits in the past 5 minutes (300 seconds). `hit(timestamp)` records one hit. `getHits(timestamp)` returns how many recorded hits have `time` in `[timestamp − 299, timestamp]`. Timestamps arrive in non-decreasing order. Several hits may share a second. Example: hits at 1, 2, 3 → `getHits(4)` is 3; hit at 300 → `getHits(300)` is 4; `getHits(301)` is 3 (the hit at 1 aged out). At most 300 calls. Timestamp up to 2e9.

## Binary search a sorted list, or drop a deque front

Doocs Solution 1: append every `timestamp` to `ts`. `getHits` finds the first index whose value is at least `timestamp − 300 + 1` (`t − 299`) and returns `len(ts)` minus that index. Because time only moves forward, `ts` stays sorted, so lower-bound search is enough.

Queue twin: store timestamps (or `(time, count)` pairs). On `getHits`, pop from the left while `front ≤ timestamp − 300`, then return the remaining size (or remaining count). Same window: keep hits strictly after `t − 300`.

Follow-up when one second can hold a huge burst: collapse that second into one queue node with a count, or 300 buckets keyed by `t mod 300`. Do not scan every historical hit on each query if you already have a sorted/queue structure.

Do not keep a running total with no expiry. Do not treat this as Logger Rate Limiter (359) — here you count a sliding 300-second window, not a per-message 10-second cooldown.

Time: O(1) hit, O(log n) getHits with binary search (or amortized O(1) with a deque)  
Space: O(n) recorded hits still in range (or all hits if you never evict)

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

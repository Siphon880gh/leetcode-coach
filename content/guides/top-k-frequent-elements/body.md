Integer array `nums` (length up to 1e5) and `k`. Return the `k` most frequent values in any order. The answer set is unique. `[1,1,1,2,2,3]`, `k = 2` → `[1,2]`. `[1]`, `k = 1` → `[1]`. Follow-up: better than O(n log n).

## Count, then keep the k heaviest (or bucket by frequency)

Hash map `cnt[x]` = how often `x` appears. A min-heap of size `k` stores `(count, value)`: push each unique key; if the heap grows past `k`, pop the smallest count. What remains is the top `k`. Time O(n + u log k) with `u` unique keys.

Bucket follow-up: `buckets[c]` is the list of values with frequency `c` (`c` is at most `n`). Walk `c` from `n` down to 1 and collect until you have `k` values. That is O(n).

Kth Largest Element (215) ranks values, not frequencies. Top K Frequent Words (692) adds lexicographic ties. Sorting every unique key by count is O(u log u) and misses the follow-up.

Do not return the counts instead of the values. Do not keep a max-heap of everything. Do not assume a unique order among the `k` keys.

Time: O(n + u log k) heap, or O(n) buckets  
Space: O(u)

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

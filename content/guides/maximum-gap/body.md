Max difference between successive elements after sorting. `n < 2` → 0. Must be linear time and linear extra space. `[3,6,9,1]` → 3. `[10]` → 0. Length up to 10⁵.

## Bucket width is the even-spread gap; the max sits between buckets

Comparison sort then adjacent diffs is O(n log n). Missing Ranges lists every hole as `[lo,hi]`, not one integer. Find Peak returns an index.

Pigeonhole: `bucket_size = max(1, (mx-mi)//(n-1))`. That width is the average successive gap if values were spread evenly, so the max successive gap cannot sit inside one bucket. Inside a bucket, two values differ by less than that width. Empty buckets are skipped; you compare this min to the previous nonempty max.

Put each `v` in `i = (v-mi)//bucket_size` and keep min/max. Walk buckets; skip empties (`min > max`); `ans = max(ans, curmin - prev)`; `prev = curmax`. First nonempty: `prev` starts as +∞ so that first subtraction does not count.

On `[3,6,9,1]`, `mi=1`, `mx=9`, `n=4`, size 2. Sorted successive gaps include 3. Not `mx-mi` (8). `[10]` is `n < 2`.

**Time:** O(n)  
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

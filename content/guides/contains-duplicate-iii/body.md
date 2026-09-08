True if some distinct `i`, `j` satisfy `abs(i − j) ≤ indexDiff` and `abs(nums[i] − nums[j]) ≤ valueDiff`. Call those `k` and `t`. `n ≤ 10⁵`. `[1,2,3,1]`, `k = 3`, `t = 0` → true (the two 1s). `[1,5,9,1,5,9]`, `k = 2`, `t = 3` → false.

## Nearby in **index** and **value**

Contains Duplicate (217) ignores distance. Contains Duplicate II (219) requires equal values inside `k`. Here values may differ by up to `t`. Nested loops are O(n²) and miss the limit. Use 64-bit arithmetic so `v ± t` does not wrap.

Keep a sliding window of the previous `k` values in an ordered set. At `v`, take the first stored number `≥ v − t`. If it exists and is `≤ v + t`, return true. Insert `v`. If `i ≥ k`, drop `nums[i − k]`. Each probe is O(log k).

Bucket twin: width `t + 1`. Put `v` in bucket `id = floor(v / (t + 1))` (shift negatives). A hit in the same bucket, or a neighbor bucket whose value is within `t`, is enough. Evict the value that just left the index window. Empty `t = 0` still works: width 1, same bucket means equal values.

Do not treat this as 219 (`t` must be 0). Do not drop the index window. Do not return the pair — only the boolean.

**Time:** O(n log k) ordered set / O(n) expected buckets  
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

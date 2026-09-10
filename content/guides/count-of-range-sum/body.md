Integer array `nums`, bounds `lower` and `upper`. Count how many contiguous ranges `i..j` (i ≤ j) have sum in `[lower, upper]`. Example `[-2,5,-1]` with `[-2, 2]` → 3 (the lone `-2`, the lone `-1`, and the whole array summing to 2). n up to 1e5, values ±2³¹, so nested loops and 32-bit prefixes both fail.

## Prefix, then count earlier values in a window

Let `s[0] = 0` and `s[k]` be the sum of the first k elements (64-bit). Range `i..j` is `s[j+1] − s[i]`. For a fixed later prefix `x = s[j]`, you need earlier prefixes `y` with `x − upper ≤ y ≤ x − lower`. Walk prefixes left to right: query that window among values already in the tree, then insert `x`. Inserting after the query keeps `i < j` so empty ranges are never counted. The dummy `s[0]` is inserted first with an empty tree (count 0), then later prefixes can pair with it.

Fenwick (Binary Indexed Tree): discretize every `s[k]`, `s[k] − lower`, and `s[k] − upper` into ranks, then range-count with prefix sums of frequencies. Merge-sort / divide-and-conquer (same family as Reverse Pairs, 493) also counts cross-half prefix pairs in O(n log n).

Do not brute-force every `i, j`. Do not treat this as Range Sum Query - Immutable (303), which answers one sum, not how many sums land in a band. Do not copy Subarray Sum Equals K (560): that is a hash of exact `s − k`, not a closed interval, and n = 1e5 still needs a ordered structure here. Do not overflow 32-bit when adding prefixes.

Time: O(n log n) Fenwick or merge  
Space: O(n)

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

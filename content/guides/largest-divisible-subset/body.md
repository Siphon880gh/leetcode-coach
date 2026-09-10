Distinct positive integers `nums` (n up to 1000). Return any largest subset where for every pair, one divides the other. `[1,2,3]` → `[1,2]` or `[1,3]`. `[1,2,4,8]` → the whole array.

## Sort, then extend a divisible chain

This is a subset, not a subsequence: order does not matter, so sort first. After sorting, a larger value can sit after a smaller one iff `larger mod smaller == 0`. Transitivity: if a divides b and b divides c, then a divides c, so a chain of such links is a valid subset.

`f[i]` = longest valid subset that ends at `nums[i]` (the value itself is length 1). For each `i`, scan `j < i`: if `nums[i] mod nums[j] == 0`, set `f[i] = max(f[i], f[j] + 1)`. Track the index `k` of the max `f`. Reconstruct: walk `i` from `k` down; whenever `nums[k] mod nums[i] == 0` and `f[i]` equals the remaining length, take `nums[i]`, move `k` to `i`, and shrink the remaining length.

Not 300: that keeps original order and compares values, it does not ask divisibility. A full power-set search is too slow. GCD of the whole array being 1 does not kill a subset (1 with 2 still works). Returning only the length is not enough — the prompt wants the values.

Time: O(n²)
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

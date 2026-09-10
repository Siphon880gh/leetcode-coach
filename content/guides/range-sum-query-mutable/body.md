Integer array `nums` that **changes**. `update(index, val)` sets `nums[index]`. `sumRange(left, right)` is inclusive. `[1,3,5]` → sum 9; `update(1, 2)` → sum 8. Length and call count up to `3×10⁴`.

## Fenwick, not a rebuilt prefix

Range Sum Query - Immutable (303) is `s[right+1] − s[left]` with no updates. Rebuilding that prefix on every `update` is O(n) and fails `3×10⁴` mixed calls. A segment tree works too; doocs Solution 1 is a Binary Indexed Tree.

1-index the tree (`c[1 .. n]`). `update(x, delta)`: while `x ≤ n`, add `delta` to `c[x]`, then `x += x & −x` (jump to the next responsible prefix). `query(x)`: sum `c[x]` while `x > 0`, then `x -= x & −x`. Inclusive range = `query(right+1) − query(left)`. On `update(i, val)`, the delta is `val` minus the current `nums[i]` (keep a copy, or `sumRange(i, i)`). Build by point-updating each value.

Do not use 303’s static prefix. Do not scan `left..right` per query. Do not forget Fenwick is 1-indexed (`index + 1`).

**Time:** O(n log n) build, O(log n) per `update` / `sumRange`  
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

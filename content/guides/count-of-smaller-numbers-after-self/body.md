For each index `i`, count how many later values are **strictly smaller**. `[5,2,6,1]` → `[2,1,1,0]`. `[-1]` → `[0]`. `[-1,-1]` → `[0,0]` (equals do not count). `n` up to 10⁵; values in `[−10⁴, 10⁴]`.

## Insert from the right; query ranks below you

A nested loop is O(n²). Range Sum Query Mutable (307) already uses a Fenwick tree for prefix sums. Here the “sum” is a **frequency** of ranks already seen to the right.

Sort unique values and map each to a 1-based rank. Walk `nums` from the right. Let `x` be the rank of the current value. `query(x − 1)` is how many already-inserted values have a smaller rank (those sit to the right and are strictly smaller). Then `update(x, 1)`. Reverse the collected answers.

Equals share a rank, so `query(x − 1)` skips them. Do not query `x` after inserting the current point (that would count yourself). `lowbit` is `x & −x` as in 307.

Merge-sort twin: sort index pairs; when a right-half value is taken before a left-half index, that left index gains one inversion. Same O(n log n).

Do not count `j < i` (left side). Do not treat this as “count smaller than nums[i] anywhere.” Do not skip rank compression on a huge value range if you Fenwick the raw values without an offset.

**Time:** O(n log n)  
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

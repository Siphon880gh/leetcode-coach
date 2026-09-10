Integer array `nums` is **immutable**. Implement `NumArray`: constructor, then many `sumRange(left, right)` calls (inclusive). `[-2,0,3,-5,2,-1]` → `sumRange(0,2)=1`, `(2,5)=-1`, `(0,5)=-3`. Length and query count up to 10⁴.

## Prefix once, then subtract

Range Sum Query 2D (304) needs a 2-D prefix. Range Sum Query Mutable (307) needs Fenwick or a segment tree because values change. Here nothing is updated, so a 1-D prefix is enough. Scanning `left..right` on every call is O(n) per query and fails the 10⁴ × 10⁴ bound.

Let `s[0] = 0` and `s[i+1] = s[i] + nums[i]` (sum of the first `i+1` elements). Then `nums[left] + … + nums[right]` = `s[right+1] − s[left]`. Inclusive: you need the extra slot so `sumRange(0, n−1)` is `s[n] − s[0]`. `accumulate(..., initial=0)` builds that array.

Do not omit the dummy 0 and then special-case `left == 0`. Do not use Fenwick for an immutable array. Do not loop the range at query time.

**Time:** O(n) build, O(1) per `sumRange`  
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

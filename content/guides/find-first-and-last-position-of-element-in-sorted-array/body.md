`nums` is non-decreasing. Return the first and last index of `target`, or `[-1, -1]` if it is absent. Must be O(log n). n ≤ 10⁵.

`[5,7,7,8,8,10]`, target `8` → `[3,4]`. Same array, target `6` → `[-1,-1]`. Empty array → `[-1,-1]`.

## Two lower bounds

A linear scan from both ends is O(n). Duplicates make a single “find any hit then walk out” also O(n) in the worst case (the whole array is `target`).

`lower_bound(x)` is the first index `i` with `nums[i] >= x` (or `n` if every value is smaller). Run it twice:

- `L = lower_bound(target)` — first index that could be `target`
- `R = lower_bound(target + 1)` — first index strictly greater than `target`

If `L == R`, the window is empty: `target` is not there. Else the closed range is `[L, R-1]`.

Implement `lower_bound` yourself: `lo, hi = 0, n` while `lo < hi`; `mid = (lo + hi) // 2`; if `nums[mid] >= x` then `hi = mid`, else `lo = mid + 1`. Return `lo`.

You do not need an “upper bound” that compares `>`. Searching for `target + 1` is the same cut when values are integers.

**Time:** O(log n)  
**Space:** O(1)

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

`nums` is strictly increasing. If `target` is present, return its index. If not, return the index where you would insert it to keep the array sorted. Must be O(log n). n ≤ 10⁴.

`[1,3,5,6]`: target `5` → 2. Target `2` → 1. Target `7` → 4.

## Lower bound

This is exactly `lower_bound(target)`: the first index `i` with `nums[i] >= target` (or `n` if `target` is larger than every value).

`lo, hi = 0, n` while `lo < hi`:

- `mid = (lo + hi) // 2`
- If `nums[mid] >= target`, the answer is at `mid` or left of it: `hi = mid`
- Else `lo = mid + 1`

Return `lo`. When `target` is in the array, that index is the unique hit (values are distinct). When it is missing, `lo` is the insertion slot — including `0` (smaller than `nums[0]`) and `n` (larger than `nums[n-1]`).

Same loop as the left edge in “first and last position.” You do not need a second search, and you do not special-case “found vs missing.”

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

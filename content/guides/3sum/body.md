Return every distinct triplet `nums[i] + nums[j] + nums[k] == 0` with three different indices. Order of triplets does not matter. n can be 3000, so O(n³) is too slow.

`[-1,0,1,2,-1,-4]` → `[[-1,-1,2],[-1,0,1]]`. `[0,1,1]` → `[]`. `[0,0,0]` → `[[0,0,0]]`.

## Sort, then two pointers

Sort first so duplicates sit together and two-sum on a suffix is linear.

Fix `i` from `0` to `n - 3`. Skip `i` if `nums[i] == nums[i-1]` (already used that first value). If `nums[i] > 0`, stop: the rest is larger too.

Set `j = i + 1`, `k = n - 1`. While `j < k`, look at `x = nums[i] + nums[j] + nums[k]`:

- `x < 0`: `j++`
- `x > 0`: `k--`
- `x == 0`: record the triple, then `j++` and `k--`, and keep skipping equal `nums[j]` / `nums[k]` so the same pair is not listed twice

**Time:** O(n²) after O(n log n) sort  
**Space:** O(log n) or O(n) for the sort, besides the answer

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

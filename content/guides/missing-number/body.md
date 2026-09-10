Array `nums` of length `n` holds `n` distinct integers from the range `0 .. n`. Return the one missing value. `[3,0,1]` → `2`. `[0,1]` → `2`. `[9,6,4,2,3,5,7,0,1]` → `8`. `n` up to `10⁴`. Follow-up: O(n) time, O(1) extra.

## XOR indices with values, or subtract from Gauss sum

Single Number XOR-folds duplicates to zero. Here every number in `0 .. n` except one appears once in the array. XOR all indices `0 .. n−1` with all `nums[i]`, and also XOR `n` (the last index of the range). Each present value cancels its matching index; the leftover is the missing one. `ans = n`, then `ans ^= i ^ nums[i]` for each `i`.

Math twin: expected sum is `n (n + 1) / 2`; subtract `sum(nums)`. Integer overflow is a language issue; XOR never adds. A set or a sort uses extra time or extra space and misses the follow-up.

Do not assume 0 is missing. Do not skip XOR-ing `n` (when `n` itself is the hole, indices `0 .. n−1` all cancel). Do not use a hash set.

**Time:** O(n)  
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

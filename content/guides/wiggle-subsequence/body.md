A wiggle sequence has successive differences that strictly alternate positive and negative (first step either way). One element is a wiggle; two unequal elements are a wiggle. A zero difference is not. Return the length of the longest wiggle subsequence (keep order, skip allowed). `[1,7,4,9,2,5]` → `6`. `[1,17,5,10,13,15,10,5,16,8]` → `7`. Strictly increasing `[1,2, …, 9]` → `2`. Length up to 1000.

## Up ending vs down ending

Let `f[i]` be the longest wiggle that ends at `i` with an up (`nums[j] < nums[i]`). Let `g[i]` end at `i` with a down. Start both at 1. For each `i`, scan earlier `j`: if `nums[j] < nums[i]`, `f[i] = max(f[i], g[j] + 1)` (you need a down before this up). If `nums[j] > nums[i]`, extend `g[i]` from `f[j]`. Equals do not extend either side. Answer is the max of all `f` and `g`. Time O(n²) is fine at n = 1000.

Follow-up O(n): keep two scalars `up` and `down` (lengths of the best wiggle so far ending up or down). Walk adjacent pairs: a rise sets `up = down + 1`; a fall sets `down = up + 1`; a plateau skips. That is greedy extrema: only peaks and valleys grow the length.

Wiggle Sort (280) reorders the array in place with non-strict waves. Wiggle Sort II (324) is a strict in-place layout. Longest Increasing Subsequence (300) does not alternate.

Do not count a plateau as a turn. Do not return n for a monotone run. Do not require a contiguous subarray.

Time: O(n²) DP, or O(n) two counters
Space: O(n) for the arrays, or O(1) greedy

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

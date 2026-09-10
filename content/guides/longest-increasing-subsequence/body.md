Integer array `nums`. Return the **length** of a longest **strictly increasing subsequence** (order preserved, not necessarily contiguous). `[10,9,2,5,3,7,101,18]` → 4 (`[2,3,7,101]`). All equal values → 1. Length 1 to 2500.

## End-at-i DP, not a contiguous run

Longest Consecutive Sequence (128) hashes values and stretches a run. Longest Common Subsequence compares two strings. Here there is one array, and you may skip cells. Sorting then scanning consecutive values also fails: the subsequence must keep original order.

`f[i]` = longest increasing subsequence that **ends at index i**. Start every `f[i]` at 1 (the element alone). For each `i`, scan `j < i`: if `nums[j] < nums[i]`, set `f[i] = max(f[i], f[j] + 1)`. Answer is the max of all `f`. Equal values never extend (strict). n = 2500 makes the O(n²) double loop acceptable.

Follow-up O(n log n): keep `tails[len]` = smallest ending value of any increasing subsequence of that length. For each `x`, binary-search the first slot whose tail is ≥ `x` and replace it (or append). `tails` stays sorted; its length is the answer. That is patience sorting, not “sort the array.” A Fenwick / segment tree over compressed values is the same idea: query max length among strictly smaller ranks, then point-update.

Do not require contiguous indices. Do not treat equals as increasing. Do not return the subsequence itself unless the prompt asks — the length is enough.

**Time:** O(n²) DP, or O(n log n) tails / Fenwick  
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

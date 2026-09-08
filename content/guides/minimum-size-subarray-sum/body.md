Positive `nums` and `target`. Shortest contiguous subarray whose sum is at least `target`. None → `0`. `n` up to `10⁵`. `target = 7`, `[2,3,1,2,4,3]` → `2` (`[4,3]`). `[1,4,4]` with 4 → `1`. Eight 1s vs 11 → `0`.

## Two pointers because every value is positive

Minimum Window Substring covers a multiset of letters. Here you cover a **numeric** threshold. Because every `nums[i] ≥ 1`, extending `r` only grows the sum and shrinking `l` only shrinks it — the window is monotone.

`l = 0`, `s = 0`, `ans` starts as “impossible” (`n + 1` or infinity). For each `r`, add `nums[r]`. While `s ≥ target`: `ans = min(ans, r − l + 1)`, then `s -= nums[l]`, `l += 1`. After the scan, if `ans` never updated, return 0. Do not return the slice; the judge wants the length. Do not shrink only once — keep shrinking so `[2,3,1,2]` of sum 8 yields length 4, then later `[4,3]` of length 2 wins.

Follow-up O(n log n): prefix sums `S` (monotone). For each left `i`, binary-search the smallest `j` with `S[j] − S[i] ≥ target`. Same answer, extra O(n) prefixes. Nested every-pair sums time out at `10⁵`.

**Time:** O(n) window; O(n log n) prefix plus binary search  
**Space:** O(1) window; O(n) prefixes

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

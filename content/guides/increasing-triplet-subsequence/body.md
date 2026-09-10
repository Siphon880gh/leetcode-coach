Integer array `nums`. True iff there are indices `i < j < k` with `nums[i] < nums[j] < nums[k]`. Not contiguous. `[1,2,3,4,5]` → true. `[5,4,3,2,1]` → false. `[2,1,5,0,4,6]` → true (`1,4,6`). n up to 5e5. Follow-up: O(n) time, O(1) extra space.

## Two candidates, not LIS-300

Longest Increasing Subsequence (300) wants the length; n = 2500 allows O(n²). Here you only need length ≥ 3, and n is too large for that DP.

Keep `mi` = smallest value seen, `mid` = smallest value that already has a strictly smaller number before it. Scan `num`: if `num > mid`, you have a third and return true. If `num ≤ mi`, set `mi = num` (a new first; `mid` still remembers a valid second from earlier). Else `num` sits strictly between, so set `mid = num`. Equals never promote (`≤` on `mi` is required). `mi` can sit to the right of `mid` after a reset; that is fine because `mid` was witnessed by some earlier smaller value, not necessarily the current `mi`.

Do not require adjacent indices. Do not copy 300’s `f[i]` table. Do not treat `num == mid` as a third.

Time: O(n)  
Space: O(1)

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

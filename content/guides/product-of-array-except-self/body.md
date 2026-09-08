`answer[i]` equals the product of all `nums[j]` with `j ≠ i`. O(n) time, **no division**. Products fit in 32-bit. `[1,2,3,4]` → `[24,12,8,6]`. `[-1,1,0,-3,3]` → `[0,0,9,0,0]`. Length 2 to `10⁵`. Follow-up: O(1) extra besides `answer`.

## Two passes on the output array

A total product then divide-by-`nums[i]` is banned (and zeros break it). Nested “times everything except i” is O(n²). Contains Duplicate only asks a boolean. Prefix sums add; here you **multiply**.

`left = 1`. For i from 0: `ans[i] = left`, then `left` becomes `left` times `nums[i]`. After this, `ans[i]` is the product of the strict left prefix. `right = 1`. For i from n−1 down to 0: `ans[i]` becomes `ans[i]` times `right`, then `right` becomes `right` times `nums[i]`. One zero: every other index is 0 and the zero’s index holds the product of the rest. Two zeros: the whole answer is 0. Do not skip zeros with a special count unless you still hit O(n) without division.

**Time:** O(n)  
**Space:** O(1) extra besides `ans`

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

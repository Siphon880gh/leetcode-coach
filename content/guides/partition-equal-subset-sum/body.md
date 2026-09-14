Integer array `nums`, length 1 to 200, each value 1 to 100. Return true if you can split into two subsets with equal sums. `[1,5,11,5]` → true (`[1,5,5]` and `[11]`). `[1,2,3,5]` → false.

## Odd total is impossible; then subset-sum to s/2

Let `s` be the total. If `s` is odd, return false. Otherwise the question is: can some subset sum to `m = s/2`? Each number is taken at most once. 2D: `f[i][j]` is whether the first `i` numbers can make sum `j`. Take or skip `x`: `f[i][j] = f[i-1][j] or (j >= x and f[i-1][j-x])`. 1D: boolean array of size `m+1`, start `f[0] = true`, walk `j` from `m` down to `x` so each `x` is used once. Answer is `f[m]`.

Partition to K Equal Sum Subsets (698) wants k buckets. Target Sum (494) assigns + or −. Coin Change (322) may reuse a coin.

Do not reuse a number in the 1D walk (forward `j` would turn this into unbounded knapsack). Do not skip the odd-sum check. Do not require contiguous subarrays.

Time: O(n m)  
Space: O(m) for the 1D table

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

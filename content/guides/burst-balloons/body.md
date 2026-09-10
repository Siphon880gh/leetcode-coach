`n` balloons, values `nums[i]`. Burst all. Bursting index `i` scores `nums[i−1] × nums[i] × nums[i+1]`; missing neighbors count as `1`. Maximize total coins. `[3,1,5,8]` → 167. `[1,5]` → 10. `n` up to 300; values `0`..`100`.

## Enumerate the last balloon left in (i, j)

Greedy “burst the smallest first” fails: order changes which neighbors are still alive. Think **last**. Pad `arr = [1] + nums + [1]`. Let `f[i][j]` be the max coins from bursting every balloon **strictly between** `i` and `j` (endpoints `i` and `j` stay). Answer `f[0][n+1]`.

If `k` is the last balloon burst in `(i, j)`, the two sides are independent and already solved as `f[i][k]` and `f[k][j]`. When `k` pops, its neighbors are still the endpoints, so you add `arr[i] × arr[k] × arr[j]`. Enumerate `k` from `i+1` to `j−1`. Fill by increasing gap: `i` descending, `j` ascending, so smaller intervals are ready (same shape as matrix-chain / unique BSTs).

Do not score a balloon as if it were first (neighbors then are adjacent in the original array). Do not leave the pads out. Do not treat `0` balloons as skippable without bursting (they still occupy a slot).

**Time:** O(n³)  
**Space:** O(n²)

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

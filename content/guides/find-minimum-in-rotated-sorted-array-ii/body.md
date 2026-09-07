Rotated sorted array, duplicates allowed; return the minimum. `[1,3,5]` → 1. `[2,2,2,0,1]` → 0. Follow-up: duplicates change the bound.

## Peel r when mid equals the right end

Find Min I compares to a fixed last and assumes unique values, so one half always drops. Search Rotated II asks presence, not the min. Linear `min()` works but is not the binary-search path. On `[3,3,1,3]`, mid can equal the last 3 while the min 1 sits to the right of mid. `r = mid` on equals would search `[3,3]` and miss 1.

`l, r = 0, n-1`. While `l < r`: if `nums[mid] > nums[r]`, `l = mid+1`; elif equal, `r -= 1`; else `r = mid`. Return `nums[l]`. Compare to the moving right end, not a frozen `nums[-1]`. Equal mid and r give no half to drop, so only decrement `r`. An all-equal array only shrinks `r` by 1 each time — worst case O(n), extra space still O(1). Unique Find Min I needs no `r -= 1` branch.

Still return the min, not a boolean. `[2,2,2,0,1]` returns 0 — the valley after the 2s.

**Time:** O(n) worst case  
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

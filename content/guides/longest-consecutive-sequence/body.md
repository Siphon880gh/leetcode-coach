Longest consecutive **value** run in an unsorted array, in O(n). Empty → `0`. Duplicates collapse. Values can sit anywhere in the index order.

`[100,4,200,1,3,2]` → `4` (`1..4`). `[0,3,7,2,5,8,4,6,0,1]` → `9`. `[1,0,1,2]` → `3`.

## Only begin where the left neighbor is missing

Sort then scan is O(n log n), too slow for the bound. Longest Increasing Subsequence is increasing, not consecutive. Maximum Subarray cares about index adjacency, not `1,2,3,4` sitting at scattered indices. Word Ladder is a string graph. You cannot allocate a parent array over 1e9 values.

`s = set(nums)`. For each `x` in `s`: if `x-1` is already in the set, skip — that `x` is the middle of a longer run, and starting there would recount a suffix. If `x-1` is missing, count `x, x+1, x+2, …` until a gap. Each number is expanded at most once, so O(n) time and O(n) space. Starting a run at every `x` can be quadratic on a long streak of n.

Return the integer length — `4`, `9`, and `3` on the samples — not the slice `[1,2,3,4]`, and not a boolean.

**Time:** O(n)  
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

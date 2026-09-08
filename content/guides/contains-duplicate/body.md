Return true if any value in `nums` appears at least twice, else false (all distinct). `n ≤ 10⁵`. `[1,2,3,1]` → true. `[1,2,3,4]` → false. `[1,1,1,3,3,4,3,2,4,2]` → true.

## Seen set; sort is the extra-space trade

Two Sum stored values to find a complement. Duplicate Emails / Delete Duplicate Emails are SQL. Contains Duplicate II asks whether a duplicate sits inside a window of size `k`. Here any second copy anywhere is enough.

Walk left to right with a hash set. If `x` is already in the set, return true. Else add `x`. After the loop, return false. `len(set(nums)) < n` is the same test. Brute nested loops are O(n²) and miss the limit.

Sort first, then scan adjacent pairs: equal neighbors mean a duplicate. That is O(n log n) time and O(1) extra if the sort is in place (the set is O(n) extra, O(n) time). Do not require the duplicates to be consecutive in the original array. Do not return the value or the indices — only the boolean.

**Time:** O(n) set / O(n log n) sort  
**Space:** O(n) set / O(1) extra in-place sort

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

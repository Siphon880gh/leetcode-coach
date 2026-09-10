Two integer arrays `nums1` and `nums2` (length 1..1000, values 0..1000). Return their intersection: each value at most once, any order. `[1,2,2,1]` and `[2,2]` → `[2]`. `[4,9,5]` and `[9,4,9,8,4]` → `[9,4]` or `[4,9]`.

## Set of one array; emit-and-clear on the other

Put every value of `nums1` in a set (or a bool array of size 1001). Scan `nums2`: if `x` is still in the set, append it to the answer and remove it so a second copy of `x` is not emitted again. That is O(n + m) time.

Intersection of Two Arrays II (350) keeps multiplicity (`min` of the two counts). This problem is unique only. Sorting both and two-pointer merging also works, but you still skip duplicates.

Do not return `[2,2]` for example 1. Do not require a sorted output. Do not treat missing-from-one as a hit.

Time: O(n + m)  
Space: O(n) for the set (or O(1) extra with a 1001-slot table)

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

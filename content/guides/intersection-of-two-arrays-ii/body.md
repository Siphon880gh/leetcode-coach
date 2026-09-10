Two integer arrays `nums1` and `nums2` (length 1..1000, values 0..1000). Return their intersection with multiplicity: a value `x` appears as many times as it shows in both arrays (the smaller of the two counts). Any order. `[1,2,2,1]` and `[2,2]` → `[2,2]`. `[4,9,5]` and `[9,4,9,8,4]` → `[4,9]`.

## Count one array; spend those counts on the other

Hash (or a 1001-slot table) `cnt[x]` = how often `x` appears in `nums1`. Scan `nums2`: if `cnt[x] > 0`, append `x` and decrement. That emits at most the leftover budget, so the result length is the sum of the pairwise mins.

Intersection of Two Arrays (349) is unique only (a set). This problem keeps duplicates. If both arrays are already sorted, two pointers walk them together and emit on equal values, advancing the side that is smaller otherwise. If `nums1` is tiny, count that one. If `nums2` lives on disk, stream it and spend the in-memory counts.

Do not unique-ify as in 349. Do not emit more copies than either array has. Do not require a sorted output unless the follow-up already sorted the inputs.

Time: O(n + m)  
Space: O(n) for the count map (or O(1) extra with a 1001-slot table)

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

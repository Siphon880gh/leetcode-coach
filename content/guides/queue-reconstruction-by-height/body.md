Each person is `[h, k]`: height `h`, and exactly `k` people in front who are at least as tall. Reconstruct the queue. Length 1 to 2000. `[[7,0],[4,4],[7,1],[5,0],[6,1],[5,2]]` → `[[5,0],[7,0],[5,2],[6,1],[4,4],[7,1]]`.

## Sort tallest first, then insert at k

Sort `people` by height descending; ties by `k` ascending. Start with an empty list. For each person `p`, insert `p` at index `p[1]`. After the tall people are placed, a shorter person’s `k` is exactly the slot among those already-present taller-or-equal bodies. Later shorter inserts shift them right but do not change who stood in front at insert time.

Sorting by `k` alone is wrong: two people with `k=0` cannot both be first unless heights decide the order. A Fenwick / segment-tree “place shortest into the k-th empty slot” also works, but the insert-from-tallest list is the usual O(n²) write-up.

Count of Smaller Numbers After Self (315) ranks how many later values are smaller. Queue Reconstruction is a placement greedy, not a merge-count.

Do not insert shortest-first into a plain list without empty-slot indexing. Do not leave both 7s adjacent when one has `k=1`. Do not treat `k` as an absolute index in the original array.

Time: O(n²) list inserts after an n log n sort  
Space: O(n)

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

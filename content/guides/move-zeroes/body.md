Move every `0` to the end of `nums` and keep the relative order of the non-zeros. In place: do not allocate a second array. `[0,1,0,3,12]` → `[1,3,12,0,0]`. `[0]` stays `[0]`. Length up to 1e4.

## k is the next non-zero slot

Remove Element (27) writes keepers to a slow index. Sort Colors partitions 0 / 1 / 2. Here you only need one write pointer.

`k = 0`. Scan `i` from 0. If `nums[i] != 0`, swap `nums[i]` with `nums[k]` and `k += 1`. After the scan, the prefix `[0 .. k)` is the original non-zeros in order, and the suffix is zeros (they were swapped rightward). `[0,1,0,3,12]`: i=1 swaps 1 into slot 0 → `[1,0,0,3,12]`, k=1; i=3 swaps 3 into slot 1 → `[1,3,0,0,12]`, k=2; i=4 swaps 12 into slot 2 → `[1,3,12,0,0]`.

Sorting would scramble non-zero order. Collecting non-zeros into a new list then filling zeros violates the in-place note. Swapping when `i == k` is a no-op (already packed). Follow-up: to cut writes, copy non-zeros into `k` only when `i != k`, then fill `nums[k ..]` with zeros.

**Time:** O(n)  
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

Reorder `nums` **in place** so `nums[0] < nums[1] > nums[2] < nums[3] …` (strict). A valid answer is guaranteed. `[1,5,1,1,6,4]` → `[1,6,1,5,1,4]` (other waves are fine). `[1,3,2,2,3,1]` → `[2,3,1,3,1,2]`. Length up to `5×10⁴`. Values sit in `0..5000`.

## Sort, then write from the two ends backward

Wiggle Sort (280) allows `≤` / `≥` and a linear adjacent swap. Here equals cannot sit next to each other as a peak/valley pair. A one-pass 280 swap can leave `1,1` neighbors.

Sort a copy `arr`. Let `i = (n − 1) // 2` (end of the smaller half) and `j = n − 1`. For `k = 0 .. n−1`: even `k` takes `arr[i]` then `i` steps left; odd `k` takes `arr[j]` then `j` steps left. Filling **backward** from each half keeps equal values from meeting at the median (forward interleave of `[1,1,2,2]` can produce `1,2,1,2` or fail with clustered equals).

Values are tiny, so a count array of size 5001 also works: dump largest remaining onto odd indices first (the peaks), then onto even indices.

Do not return a new array. Do not reuse 280’s adjacent swap. Do not require a unique wave.

**Time:** O(n log n) sort, or O(n) counting  
**Space:** O(n) copy, or O(1) extra besides a 5001-bucket

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

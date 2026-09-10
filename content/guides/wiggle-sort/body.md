Reorder `nums` **in place** so `nums[0] ≤ nums[1] ≥ nums[2] ≤ nums[3] …`. A valid answer is guaranteed. `[3,5,2,1,6,4]` → `[3,5,1,6,2,4]` (other waves are fine). `[6,6,5,6,3,8]` can stay. Length up to `5×10⁴`. Follow-up: O(n).

## Adjacent swap on the broken edge

Wiggle Sort II (324) wants a **strict** `< > < >` using a median and virtual indices. Zigzag Iterator walks two lists. Here equals are allowed (`≤` and `≥`).

Sort then pick small/large from both ends is O(n log n) and works. The linear pass: for `i` from 1 to n−1, if `i` is odd you need a peak (`nums[i] ≥ nums[i−1]`); if even you need a valley (`nums[i] ≤ nums[i−1]`). When the pair is wrong, **swap** those two. A swap at `i` cannot break the previous pair: an odd peak swap raises `i` and lowers `i−1`, which still sits above the earlier valley, and the even case is symmetric. Equals do not swap.

Do not return a new array. Do not require strict inequalities (II). Do not sort unless you skip the follow-up.

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

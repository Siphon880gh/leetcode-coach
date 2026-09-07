The majority value appears more than ⌊n / 2⌋ times and is guaranteed to exist. Follow-up: linear time, O(1) extra space. `[3,2,3]` → 3. `[2,2,1,1,1,2,2]` → 2. n up to 5×10⁴.

## Boyer-Moore: reset the candidate when the counter hits 0

A hash of counts is O(n) extra. Sorting and picking the median is O(n log n). Excel titles and Two Sum II are other problems. Majority Element II (n/3) is a later cousin. Returning `nums[0]` is luck: `[3,2,3]` starts with 3, but that is not the algorithm.

If `cnt` is 0, set `m` to `x`. Else add 1 when `x` equals `m`, else subtract 1. Because a majority exists, the first pass’s candidate is enough; no confirm scan.

Walk `[3,2,3]`: 3 sets `m=3`, `cnt=1`; 2 cancels to 0; 3 sets `m=3` again. `[2,2,1,1,1,2,2]`: after the three 1s the count hits 0, then the last 2s reclaim `m`. Three 1s are not more than n/2, so 1 is not majority.

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

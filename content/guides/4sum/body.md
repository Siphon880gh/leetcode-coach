Return every unique quadruplet of **values** (distinct indices) that sums to `target`. n ≤ 200, values and target up to 10⁹, so four ints can overflow 32-bit addition.

`[1,0,-1,0,-2,2]`, target `0` → `[[-2,-1,1,2],[-2,0,0,2],[-1,0,0,1]]`. `[2,2,2,2,2]`, target `8` → `[[2,2,2,2]]`.

## 3Sum with an extra outer index

Sort. Nested loops on `i` then `j > i`. Skip `i` / `j` when equal to the previous first / second value. Two pointers `k = j + 1`, `l = n - 1` on the suffix:

- sum too small → `k++`
- too large → `l--`
- equal → record, then move both and skip duplicate `nums[k]` / `nums[l]`

If `n < 4`, return `[]`.

**Time:** O(n³)  
**Space:** O(log n) or O(n) for the sort, besides the answer

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

Two sorted arrays `nums1` (length m) and `nums2` (length n). Return the median of the combined sorted sequence in **O(log(m+n))** time. Merging into one array is O(m+n) and misses the bound.

The median is the average of the k₁-th and k₂-th order statistics, with k₁ = ⌊(m+n+1)/2⌋ and k₂ = ⌊(m+n+2)/2⌋. When m+n is odd those two k’s are the same element, so the average is still correct.

## Find the k-th in two remaining suffixes

`f(i, j, k)`: k-th smallest among `nums1[i:]` and `nums2[j:]`.

- `i` past the end → take `nums2[j+k-1]`
- `j` past the end → take `nums1[i+k-1]`
- `k == 1` → `min(nums1[i], nums2[j])`
- Else compare the ⌊k/2⌋-th remaining value in each array (treat a short array as +∞). The smaller side cannot hold the overall k-th, so drop those ⌊k/2⌋ elements and recurse with k reduced by that count.

Each call halves k, so the depth is O(log(m+n)).

**Time:** O(log(m+n))  
**Space:** O(log(m+n)) if recursive; O(1) if you loop the same cut.

## `[1,3]` and `[2]`

Total length 3, both k’s are 2. After comparing halves you land on `2`. Average is 2.0.

## `[1,2]` and `[3,4]`

k₁ = 2, k₂ = 3 → 2 and 3, average 2.5.

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

Count index triples `i < j < k` with `nums[i] + nums[j] + nums[k] < target`. `[-2,0,1,3]`, target `2` → `2` (`[-2,0,1]` and `[-2,0,3]`). Empty or one element → `0`. `n ≤ 3500`. The answer fits in 10⁹.

## Count windows, do not skip duplicates like 3Sum

3Sum (15) lists **distinct value** triples that equal 0, so equal neighbors are skipped. 3Sum Closest (16) tracks the nearest sum. Here you **count** index triples under a strict less-than; repeats still count as different indices.

Sort, then fix `i` from `0` to `n − 3`. Set `j = i + 1`, `k = n − 1`. While `j < k`: if `nums[i] + nums[j] + nums[k] < target`, every `k′` in `(j, k]` also works (the array is sorted, those values are `≤ nums[k]`), so add `k − j` and `j += 1`. Else the current k is too big: `k -= 1`. Do not O(n³) enumerate. Do not stop at the first valid pair. Do not skip equal values (that would undercount indices).

**Time:** O(n²) after O(n log n) sort  
**Space:** O(log n) or O(n) for the sort

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

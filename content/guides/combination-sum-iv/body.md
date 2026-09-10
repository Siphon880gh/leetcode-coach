Distinct positive integers `nums` (length up to 200) and a `target` (up to 1000). Count the sequences that add to `target`. Order matters: `[1,2,3]`, target `4` → `7` because `(1,3)` and `(3,1)` are different. `[9]`, target `3` → `0`. The answer fits in a 32-bit signed int.

## Outer loop is the sum, so order is a permutation

Let `f[i]` be the number of sequences that sum to `i`. `f[0] = 1` (one empty sequence). For `i` from 1 to `target`, for each value `x` in `nums`, if `i ≥ x` add `f[i − x]`. That last step `x` can follow any sequence for `i − x`, so rearrangements are counted separately.

If you loop coins on the outside and sums on the inside, you count combinations (each multiset once). That is Coin Change II (518), not this problem. Combination Sum (39) lists unique sets with reuse, via DFS. Coin Change (322) is the fewest coins, not the count.

Follow-up with negatives: sequences can grow forever, so you need a bound (max length, or no zeros/negatives that cycle).

Do not sort and skip duplicates as in Combination Sum II. Do not return 1 for `[1,2,3]` target 4. Watch overflow in languages with 32-bit ints (C++ seeds a cap).

Time: O(n × target)
Space: O(target)

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

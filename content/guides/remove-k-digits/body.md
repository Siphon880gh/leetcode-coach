`num` is a digit string of length up to `10⁵` (no leading zeros except `0` itself). Delete exactly `k` digits (`1 ≤ k ≤ n`) so the remaining digits, in order, form the smallest integer. Return it as a string with no leading zeros, or `"0"` if nothing useful remains. `1432219` and `k = 3` → `1219` (drop 4, 3, 2). `10200` and `k = 1` → `200` (drop the leading 1). `10` and `k = 2` → `0`.

## Pop a larger top when a smaller digit arrives

Build a stack that stays non-decreasing. For each digit `c`, while `k` is still positive and the top is greater than `c`, pop the top and spend one removal. Then push `c`. After the scan, leftover removals chop the tail (the number was already non-decreasing). Keep only the first `n − k` digits of the stack (Python slices to `remain = n − k` even if extra digits were pushed). Strip leading zeros.

A left peak is always worse than keeping a later smaller digit in that place: `143` with one removal wants `13`, not `14`. Trying every subset of deletions is exponential; one left-to-right pass is linear.

Remove Duplicate Letters (316) also uses a monotonic stack, but it must keep every letter once and can look ahead at remaining counts. Create Maximum Number (321) builds the largest merge of two arrays. Neither is “smallest after k deletes.”

Do not return `0200` for the second example. Do not delete the rightmost digits first on `1432219` (that would keep `1432`). Do not treat `k = n` as an empty string — the answer is `0`.

Time: O(n)  
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

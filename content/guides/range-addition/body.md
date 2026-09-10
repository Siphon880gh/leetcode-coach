Integer `length` (n up to 1e5) and `updates` of size up to 1e4. Start from a zero array of that length. Each update `[start, end, inc]` adds `inc` to every index in the inclusive range `[start, end]`. Return the array after all updates. `length = 5`, `[[1,3,2],[2,4,3],[0,2,−2]]` → `[−2,0,3,5,3]`.

## Mark the boundaries; prefix to restore

Difference array `d` (same length as the answer). For `[l, r, c]`: `d[l] += c`. If `r + 1 < n`, `d[r + 1] −= c`. After every update, walk left to right: `d[i] += d[i − 1]`. That running sum is the final array.

Each range is two writes, not a loop over `r − l + 1` cells. n and k make a naive O(n k) scan too slow. Range Sum Query - Mutable (307) answers live queries with a Fenwick tree; here you apply a batch and return once — no tree needed. Corporate Flight Bookings (1109) is the same template.

Do not forget the `r + 1 < n` guard (a range that ends at the last index has no cancel slot). Ranges are inclusive on both ends. `inc` can be negative.

Time: O(n + k)
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

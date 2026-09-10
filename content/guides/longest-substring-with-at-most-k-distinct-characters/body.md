String `s`, integer `k`. Length of the longest substring that uses at most `k` distinct characters. `"eceba"`, `k = 2` → 3 (`"ece"`). `"aa"`, `k = 1` → 2. `k = 0` → 0. Length up to 5e4; `k` up to 50.

## Grow right; shrink while the map has more than k keys

Walk `right`. Increment `cnt[s[right]]`. While `cnt` has more than `k` keys, decrement `cnt[s[left]]`, delete the key if the count hits 0, then `left += 1`. Then `ans = max(ans, right − left + 1)`.

Doocs Solution 1 shrinks at most once per step and returns `len(s) − left`. That is only safe because you need the length, not the slice: the window size never exceeds the best valid width, even if the final `[left, n)` is briefly invalid.

159 is this problem with `k` glued to 2. 3 (no repeats) is at most one of each character, a different constraint. 904 Fruit Into Baskets is the same window with `k = 2` on a fruit array.

Do not require exactly `k` distinct (at most, so fewer is allowed). Do not restart a new window from `right` when you exceed `k` (only the leftover counts on the left need to leave). Do not scan every pair of indices.

Time: O(n)  
Space: O(k)

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

Max number of unique points on one straight line. `[[1,1],[2,2],[3,3]]` → 3. Second sample → 4. `n` ≤ 300.

## GCD-reduced slope keys

Float `dy/dx` as a hash key collides or misses from rounding. Sort List, LRU, and tree max path sum are different problems. Hashing raw `(dx, dy)` splits `(2,4)` and `(1,2)` into different buckets even though they are the same slope from origin `i`. Cross-product collinearity `(y2−y1) × (x3−x1) == (y3−y1) × (x2−x1)` also works in O(n³) and is fine at `n` = 300.

`ans` starts at 1 (one point is a line). For each origin `i`, a fresh counter. For `j > i`: `g = gcd(dx, dy)`; `cnt[(dx/g, dy/g)] += 1`; `ans = max(ans, cnt[key] + 1)`. The counter only stores other points; origin `i` is not in the map, so plus 1 is point `i` itself, not a dummy sentinel. Points are unique, so no duplicate-at-`i` loop. Vertical lines: `dx = 0`, reduced `(0, ±1)` after gcd.

`[[1,1],[2,2],[3,3]]` returns 3 — one slope from the first point hits both others.

**Time:** O(n²) with the hash (O(n³) for the triple loop)  
**Space:** O(n) for one origin’s map

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

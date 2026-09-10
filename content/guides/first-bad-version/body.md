You have versions `1 .. n`. There is a first bad version `bad`; every version after it is also bad. Call `isBadVersion(version)` as few times as possible. Return that first bad index. `n = 5`, `bad = 4` → `4`. `n = 1`, `bad = 1` → `1`. `n` up to `2³¹ − 1`.

## Lower bound on a monotone false…true array

H-Index II searches a sorted citations array. Guess Number is a different API. Here `isBadVersion` is **monotone**: once it becomes true, it stays true. The answer is the leftmost true.

`l = 1`, `r = n`. While `l < r`: `mid = (l + r) >>> 1` (or `l + (r − l) / 2`) so `l + r` cannot overflow a 32-bit signed int. If `isBadVersion(mid)` is true, the first bad is in `[l, mid]` → `r = mid`. Else it is in `[mid + 1, r]` → `l = mid + 1`. When the loop ends, `l == r` is the first bad. `n = 1` never enters the loop and returns 1.

Do not scan from 1 to n (too many API calls). Do not set `r = mid − 1` when mid is bad (you might skip the first bad). Do not use signed `(l + r) / 2` when `n` is `2³¹ − 1`.

**Time:** O(log n) API calls  
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

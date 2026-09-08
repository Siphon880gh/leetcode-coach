Count how many times the **decimal digit** `1` appears in all integers from `0` through `n`. `13` → `6` (`1`, `10`, `11` twice, `12`, `13`). `0` → `0`. `0 ≤ n ≤ 10⁹`.

## Place-by-place search, not a loop to n

Number of 1 Bits (191) counts **binary** 1s of a single `n`. Plus One adds to a digit array. Scanning `1 .. n` is O(n) and dies at a billion. You count 1s in the decimal writing of every value `≤ n`.

Let `s = str(n)`. `dfs(i, cnt, limit)`: position `i` from the left, `cnt` ones already placed, `limit` true iff the prefix matches `n` so far. If `i` is past the last digit, return `cnt` (this complete number contributes that many ones). Upper digit `up` is `s[i]` under `limit`, else `9`. For `j` from `0` to `up`, recurse `i+1`, `cnt + (1 if j == 1 else 0)`, and `limit` stays true only if `limit` and `j == up`. Cache `(i, cnt)` when `limit` is false — those suffixes are free of `n`. Answer `dfs(0, 0, True)`. Leading zeros are just digit `0`; they do not add ones.

Do not memoize while `limit` is true (the bound still depends on the remaining digits of `n`). Do not count `11` as one occurrence. Place-wise math (how many 1s sit in the tens, hundreds, …) is the same count in O(log n) closed form.

**Time:** O(m² · 10) with m ≤ 10 digits  
**Space:** O(m²) memo

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

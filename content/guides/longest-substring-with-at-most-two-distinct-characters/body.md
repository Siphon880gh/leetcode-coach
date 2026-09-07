Longest substring with at most two distinct characters. `eceba` → 3 (`ece`). `ccaabbb` → 5 (`aabbb`). Length up to 10⁵. English letters.

## Shrink only while more than two keys

LC 3 forbids any duplicate. Here `ece` is valid: two letters, `c` repeats. Scanning every substring is O(n²) and too slow at 10⁵. Read4 leftovers are a file buffer, not a window.

For each `i`: `cnt[c] += 1`. While `len(cnt) > 2`: decrement `s[j]`, pop the key if its count hits 0, then `j += 1`. Then `ans = max(ans, i - j + 1)`. Repeats of the same two letters are allowed. The invariant is at most two keys, not all counts equal to 1.

On `eceba`, after `e,c,e` the map has two keys and `ans` is 3. Then `b` makes three. Advance `j` past the first `e` then `c`; the window is `eb`; `ans` stays 3 from `ece`. `j` only moves forward. Jumping `j` to `i` throws away the running max.

`ccaabbb`: after the last `b` the window is `aabbb` — two keys, length 5. Not a subsequence like `eea`. Time O(n), space O of alphabet size.

**Time:** O(n)  
**Space:** O of alphabet size

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

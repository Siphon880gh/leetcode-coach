`pattern` and string `s` (both lowercase, length 1..20). True iff there is a **bijection** from letters to non-empty substrings: replace each letter by its string and you get `s`. No two letters share a string; no letter maps to two strings. `"abab"` / `"redblueredblue"` → true (`a` → `"red"`, `b` → `"blue"`). `"aaaa"` / `"asdasdasdasd"` → true (`a` → `"asd"`). `"aabb"` / `"xyzabcxzyabc"` → false.

## Word Pattern already splits; here you invent the cuts

Word Pattern (290) splits `s` on spaces, then two maps. Word Break (139) asks whether `s` concatenates dictionary words — no letter bijection. Here the dictionary is **invented** while you walk `pattern`.

`dfs(i, j)`: `i` is the next pattern index, `j` the next start in `s`. Both at the end → true. One leftover, or remaining chars `<` remaining letters (each letter needs at least one char) → false. For each end `k` from `j` to `n − 1`, take `t = s[j .. k]`:

- If `pattern[i]` is already mapped to `t`, recurse `dfs(i + 1, k + 1)`
- Else if the letter is unbound and `t` is not already used by another letter: bind, recurse, unbind

First success returns true. Fail every cut → false.

Do not skip the used-string set (`"ab"` cannot map both letters to `"aa"`). Do not treat this as Word Pattern’s space split. Do not stop at the first letter’s first cut without backtracking (the `"aaaa"` / `"asdasdasdasd"` mapping is length 3, not 1).

**Time:** exponential in n (n ≤ 20)  
**Space:** O(m + n) maps, used set, and recursion

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

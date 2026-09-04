Decide whether pattern `p` matches **all** of `s`. `.` is any one character. A star after a token means zero or more of that token (an `a` then a star, or `.` then a star). `"aa"` vs `"a"` is false; `"aa"` vs `a` plus a star is true; `"ab"` vs `.` plus a star is true.

Lengths are tiny (≤ 20), so a memoized walk over indices is enough.

## `dfs(i, j)`

Does `s[i:]` match `p[j:]`?

- Pattern exhausted: success only if `s` is exhausted too.
- Next pattern char is `*`: you may
  - skip the pair (`j + 2`) — zero copies of `p[j]`
  - or, if `s[i]` matches `p[j]` (equal or `.`), consume `s[i]` and **keep** `j` (one more copy)
- Otherwise one-for-one: `s[i]` must match `p[j]`, then `dfs(i+1, j+1)`.

Cache `(i, j)` so overlapping branches are O(m·n).

**Time:** O(m·n)  
**Space:** O(m·n) for the cache

The `*` branch is the whole idea: zero copies vs “eat one and retry the same star.”

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

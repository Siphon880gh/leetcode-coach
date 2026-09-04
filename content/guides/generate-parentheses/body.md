Return every well-formed string that uses exactly `n` pairs of `()`. n is 1..8, so brute DFS with prune is enough. `n = 3` → `((()))`, `(()())`, `(())()`, `()(())`, `()()()`.

## Counts, not a full stack

DFS on `(l, r, t)`: `l` / `r` used so far, `t` the prefix.

Invalid (return): `l > n` or `r > n` or `l < r` (a closer with no matching opener in the prefix).

Done: `l == n` and `r == n` — append `t`.

Otherwise try `(` then `)`.

That `l < r` cut is the same invariant as Valid Parentheses: the running prefix is always a valid prefix of some complete string.

**Time:** O(C_n × n) where C_n is the Catalan number (the writeup bounds search as O(2^{2n} × n))  
**Space:** O(n) recursion plus the answer list

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

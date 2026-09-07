Match the **entire** string `s` against pattern `p`. `?` matches any one letter. A glob star (`*`) matches any run of letters, including empty. This is not regex: a glob star does not bind to the previous token.

`"aa"` vs `"a"` → false. `"aa"` vs `"*"` → true. `"cb"` vs `"?a"` → false. Lengths up to 2000.

## DP on prefixes

`dfs(i, j)`: does `s[i:]` match `p[j:]`? Memoize `(i, j)`.

- `s` exhausted: remaining pattern must be only glob stars (each one can eat empty).
- `p` exhausted with `s` leftover: false.
- `p[j]` is a glob star: stay on the star and eat one more `s` char (`i+1, j`), or leave the star (`i, j+1`). Eating and advancing both at once is covered by those two.
- Else the current chars must agree (`?` or equal letters), then `i+1, j+1`.

Bottom-up: `dp[i][j]` same recurrence on prefixes, `dp[0][0] = true`, and `dp[0][j]` true while the pattern prefix is all glob stars.

Regular-expression matching (`.` and a postfix star) is a different automaton. Here the star is a token by itself.

**Time:** O(m × n)  
**Space:** O(m × n)

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

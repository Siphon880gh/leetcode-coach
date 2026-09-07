Every piece of a cut must be a palindrome; return **all** cuts. `n` ≤ 16, lowercase letters.

`aab` → `[[a,a,b],[aa,b]]`. `a` → `[[a]]`.

## Palindrome table, then DFS partitions

Valid Palindrome is a boolean. Palindrome Number is digits of an int. Longest Palindromic Substring is one span. Palindrome Partitioning II is the fewest extra cuts (an integer). Restore IP is four numeric octets. Subsets take/skip without a palindrome check. Here you list every partition of the whole string.

Seed `f[i][j]` true on the diagonal (one letter). Fill from larger `i` downward: `f[i][j] = (s[i] == s[j]) and f[i+1][j-1]` (the inner pair is already known). Then `dfs(i)`: if `i == n`, append a **copy** of `t` and return. For `j` from `i` to `n-1`, if `f[i][j]`, push `s[i..j]`, `dfs(j+1)`, pop. Later pops mutate `t`; without `t[:]`, every stored partition becomes the same empty list.

Return both `[[a,a,b],[aa,b]]` — not `true`, not a min cut of `1`, and not only `[aa,b]`.

**Time:** O(n · 2^n)  
**Space:** O(n²) for `f`, plus the answer

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

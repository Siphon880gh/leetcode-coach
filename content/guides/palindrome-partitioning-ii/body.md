Fewest cuts so every piece is a palindrome. `n` up to 2000.

`aab` → `1` (`aa|b`). `a` → `0`. `ab` → `1`.

## Palindrome table, then min-cut DP

Palindrome Partitioning I returns `[[a,a,b],[aa,b]]`. Enumerating partitions is exponential; at 2000 that is too slow. Valid Palindrome is a boolean. Longest Palindromic Substring is one window. Edit Distance is insert/delete/replace. You only need the smallest cut count.

Build the same table as I: `g[i][j]` means `s[i..j]` is a palindrome. Then `f[i]` = min cuts for the prefix ending at `i`. Initialize `f[i] = i`: cutting after every character is always legal (single letters are palindromes), so it is a safe upper bound. Do **not** start at `0` — `ab` needs 1 cut, and min with 0 would stick at 0.

If `g[0][i]`, the whole prefix is a palindrome and `f[i] = 0`. Else, for each last palindrome `s[j..i]` (`j > 0`), `f[i] = min(f[i], 1 + f[j-1])`.

Return `f[n-1]` — `1`, `0`, and `1` on the samples — not I’s lists, and not a boolean.

**Time:** O(n²)  
**Space:** O(n²)

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

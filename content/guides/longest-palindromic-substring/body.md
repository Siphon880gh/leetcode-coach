Return the longest palindromic **substring** of `s` (n ≤ 1000). `"babad"` yields `"bab"` or `"aba"`; `"cbbd"` yields `"bb"`. Expanding every center is also O(n²); the writeup’s table makes the recurrence explicit.

## Interval DP

`f[i][j]` is whether `s[i..j]` is a palindrome. Single characters (and the empty inside of two equal neighbors) start as true.

For `j > i`:

- If `s[i] != s[j]`, `f[i][j]` is false
- Else `f[i][j] = f[i+1][j-1]`

That uses a **shorter** interval, so enumerate `i` from the right and `j` to the right of `i`. Whenever `f[i][j]` is true and the length beats the best so far, store start `i` and length `j-i+1`.

**Time:** O(n²)  
**Space:** O(n²) for the table (expand-around-center uses O(1) extra).

## `"cbbd"`

Length-1 palindromes are everywhere. `bb` at indices 1–2: ends match and the inside is empty → true, length 2. Nothing longer wins.

## `"babad"`

Both `"bab"` and `"aba"` have length 3; keep the first one you record if you only update on a **strictly** longer window.

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

Unique lowercase words, all the same length `n` (1 to 4), at most 1000 of them. Return every word square you can build. The same word may appear more than once in a square. `["area","lead","wall","lady","ball"]` → two squares starting `ball` and `wall`. `["abat","baba","atan","atal"]` → two squares that reuse `baba`.

## Next prefix is already written down the column

A square of side `n` needs `n` words. After you have placed `r` rows, the next word must start with the vertical slice `t[0][r] t[1][r] … t[r-1][r]` — those letters are already fixed by earlier rows. Put every word into a 26-way trie and store word indexes on each prefix node so that lookup returns all candidates for that prefix in linear time in `n`.

Backtrack: try each word as row 0, then dfs. When `len(t) == n`, copy `t` into the answer. Otherwise search the trie for the forced prefix and try each index, push, recurse, pop.

Valid Word Square (422) only checks one given (possibly jagged) matrix. Word Search II (212) walks a board, not a square of whole words. Do not require words to be used at most once — the statement allows reuse. Do not brute-force all n-tuples of 1000 words without a prefix filter.

Time: exponential in n (n is at most 4), pruned by the trie  
Space: O(total letters) for the trie plus O(n) for the path

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

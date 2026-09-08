`m × n` board of lowercase letters, `words` unique, length at most 10, up to `3×10⁴` words. Return every word that appears as a 4-neighbor path with no cell reused in that word. `[["o","a","a","n"],["e","t","a","e"],["i","h","k","r"],["i","f","l","v"]]`, `["oath","pea","eat","rain"]` → `["eat","oath"]`. `[["a","b"],["c","d"]]`, `["abcb"]` → `[]`.

## One DFS; the trie is the word list

Word Search matches **one** string from every start. Repeating that for 30k words times out. Implement Trie / Design Add and Search Words already store prefixes. Insert each word with its index in `ref` (`−1` means “not a word”). From every cell, `dfs(node, i, j)`: if this letter has no child, return. Step to that child. If `ref ≥ 0`, append `words[ref]` and set `ref = −1` so a later path does not emit twice. Write `#` on the cell, recurse on four in-bound neighbors that are not `#`, then restore the letter.

Do not search each word independently (Word Search I in a loop). Do not allow diagonals. Do not skip the `#` mark — `"abcb"` on a 2 by 2 board must fail because it would reuse `b`. Shared prefixes share one walk: `"eat"` and `"oath"` both use the `a` region without two full dictionaries.

**Time:** O(m × n × 4^L) with L ≤ 10, plus O(total word characters) to build the trie  
**Space:** O(total word characters) for the trie plus O(L) recursion

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

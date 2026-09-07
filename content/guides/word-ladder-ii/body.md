Return **every shortest** `beginWord → endWord` ladder: one letter per step, each word from the list. `beginWord` need not sit in `wordList`. If `endWord` is missing, return `[]`.

`hit → cog` with `[hot,dot,dog,lot,log,cog]` → two paths of length 5: `[[hit,hot,dot,dog,cog],[hit,hot,lot,log,cog]]`.

## BFS layers, then DFS the predecessor DAG

Word Ladder I returns the integer `5` (or `0`). Here the judge wants the sequences. Plain DFS can wander into a longer `hit-hot-dot-lot-log-cog` path. Restore IP is dotted segments. Word Search is a board. Valid Palindrome is two pointers. This is an implicit word graph plus reconstruction.

Put the list in a set; if `endWord` is absent, return `[]`. BFS from `beginWord` by layers. On each layer, try 26 letter swaps at each index. The first time you meet a word, record its distance and enqueue it. If you already queued that word **on this same layer**, still add the extra parent — several shortest routes can arrive together. Do not keep expanding after the layer that contains `endWord`; later layers are longer.

`prev[word]` points **backward**. DFS from `endWord` toward `beginWord`, reverse each path, pop on the way back. Return the list of word lists — those two ladders, or `[]` — not the integer `5`, and not only one ladder.

**Time:** O(n × L × 26) for BFS on n words of length L, plus DFS over the shortest DAG  
**Space:** O(n × L) for the graph and paths (the judge bounds the total length of all shortest sequences)

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

Number of **words** in the shortest `beginWord → endWord` ladder (one letter per step, words from the list). If `endWord` is missing or unreachable, return `0`.

`hit → cog` with `[hot,dot,dog,lot,log,cog]` → `5` (`hit-hot-dot-dog-cog`). Not `4` letter-changes.

## BFS layers, return the word count

Word Ladder II returns every shortest sequence. Here you only want the length. Unbounded DFS can report 6 or more on the same graph. Restore IP, Word Search, and Valid Palindrome are other graphs or strings.

Put the list in a set. Queue from `beginWord` with `ans = 1` (begin is already one word). Each layer: bump `ans`, then for every word on this layer try 26 replacements per index. When you first generate `endWord`, return `ans`. Remove a neighbor from the set as you enqueue it so you never visit it again. Empty queue → `0`. You do not keep `prev` pointers.

Return the integer — `5` or `0` — not `[[hit,hot,dot,dog,cog], …]` and not a boolean.

**Time:** O(n · L · 26)  
**Space:** O(n · L)

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

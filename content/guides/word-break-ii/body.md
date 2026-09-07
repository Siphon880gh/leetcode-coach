Return every way to insert spaces so each piece is in the dict (any order). Reuse allowed. `n` ≤ 20.

`catsanddog` with `[cat, cats, and, sand, dog]` → `[cats and dog, cat sand dog]`. `catsandog` → `[]`.

## DFS every dict prefix

Word Break I’s `f[n]` only says whether a split exists. Word Ladder II is a different graph. Greedy keeps one split. Palindrome Partitioning cuts palindromes, not dictionary words. Decode Ways returns a count of mappings, not `List[str]` sentences.

Put the words in a trie (or a set). DFS: if `s` is empty, return `[[]]` — one successful empty tail so a complete prefix can join. Returning `[]` from the empty string means no completions, so every prefix path dies. For `i` from 1 to `len(s)`, if `s[:i]` is a word, prepend it onto each list from `dfs(s[i:])`. Then join each list with a single space.

`n` is only 20, so exploring prefixes is fine. Impossible strings yield `[]`. Return the sentences themselves, not true/false.

**Time:** exponential in `n` (output can be large; `n` ≤ 20)  
**Space:** O(n) recursion plus the answer lists

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

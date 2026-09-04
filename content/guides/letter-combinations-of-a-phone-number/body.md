Digits `2`–`9` map like a phone keypad: `2` `abc`, `3` `def`, … `7` `pqrs`, `9` `wxyz`. Return every string you can type by picking one letter per digit. Order does not matter. Length is at most 4, so 4⁴ = 256 strings is the worst case.

`"23"` → `ad ae af bd be bf cd ce cf`. `"2"` → `a b c`. Empty input → `[]`.

## Product of prefixes

Keep `ans = [""]`. For each digit, replace `ans` with `{prefix + letter}` for every old prefix and every letter on that key. That is BFS-style expansion; DFS backtracking (append, recurse, pop) builds the same set.

**Time:** O(4ⁿ) strings, each of length n  
**Space:** O(4ⁿ) for the output (plus O(n) if you recurse)

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

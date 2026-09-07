Insert dots so `s` becomes valid IPv4: four parts, each 0..255, no leading zeros. Do not reorder or drop digits. Length ≤ 20.

`25525511135` → `255.255.11.135` and `255.255.111.35`. `0000` → `0.0.0.0`.

## Four octets, no leading zeros

Decode Ways counts 1–26 letter codes. atoi reads one integer. Generate Parentheses prunes by balance. An IP needs exactly four octets.

`dfs(i)`: for `j` in `i .. min(i+2, n-1)`, if the slice is a legal octet, append, recurse `j+1`, pop. A multi-digit octet cannot start with 0; a single 0 is allowed (`0000` is four zeros, not one 0). Record when `i == n` and you already have four parts. If you run out of digits early or already have four parts with digits left, return. Return all dotted strings, not a count.

**Time:** O(n × 3^4)  
**Space:** O(n)

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

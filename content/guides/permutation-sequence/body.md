The set `1 .. n` has `n!` permutations in lex order. Return the k-th as a string (k is 1-based). n ≤ 9.

`n = 3`, `k = 3` → `"213"`. `n = 4`, `k = 9` → `"2314"`. `n = 3`, `k = 1` → `"123"`.

## Pick by (n-i-1)! blocks

Once the first digit is fixed, the rest form `(n-1)!` strings. For slot `i` (0-based), that block size is `fact = (n-i-1)!`. Walk unused digits `1 .. n` in order. If `k > fact`, this digit is not in the answer yet: subtract `fact` and try the next unused. Otherwise append it, mark `vis`, and move to the next slot.

k stays 1-based: the first block still owns `k = 1 .. fact`. Always taking the smallest unused would make every answer start with 1 — for `n = 3`, `k = 3` the first digit is 2 (skip 1’s block of size 2, then take 2 with k now 1).

Listing all `n!` strings is Permutations I. Walking `next_permutation` k-1 times works but is slower. Here each of n slots scans at most n unused digits.

**Time:** O(n²)  
**Space:** O(n) for `vis` and the answer

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

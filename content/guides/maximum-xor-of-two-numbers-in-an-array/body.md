Integer array `nums`, length 1 to 2e5, values 0 to 2^31−1. Return the maximum of `nums[i] XOR nums[j]` for any `i <= j`. `[3,10,5,25,2,8]` → 28 because 5 XOR 25 is 28. The second sample is 127.

## Greedy opposite bit from the MSB

A binary trie stores each number as 31 bits, high bit first (index 30 down to 0). Insert every value. To query `x`, at bit `i` let `v` be that bit of `x`. If the child `v XOR 1` exists, take it and set that bit in the answer (you can make a 1 in the XOR). Else stay on `v`. The max over queries is the answer. Insert-then-query (or query-then-insert) both work because a number XOR itself is 0.

Hash-set prefixes from bit 30 down also work: after seeing prefixes of `ans` with the next bit forced on, check whether some prefix XOR that candidate exists.

Single Number (136) XORs the whole array. Two Sum (1) hunts a sum, not a bit-greedy XOR. Pairwise XOR is O(n²) and will not finish at n = 2e5.

Do not start the trie at bit 31 (values fit in 31 bits 0..30). Do not skip inserting before the first search if you query as you go without a seed. Do not treat XOR as addition.

Time: O(31 n)  
Space: O(31 n)

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

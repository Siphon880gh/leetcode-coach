Integer `n` up to about 5×10^4. Return every integer in `[1, n]` in lexicographical order. `n = 13` → `[1, 10, 11, 12, 13, 2, 3, 4, 5, 6, 7, 8, 9]`. `n = 2` → `[1, 2]`. Must be O(n) time and O(1) extra space besides the answer.

## Digit-trie walk (iterative DFS)

Start `v = 1`. Repeat n times: append `v`. Prefer going deeper: if `10×v ≤ n`, set `v` to `10×v` (append a 0). Otherwise you cannot extend, so while `v` ends in 9 or `v + 1` would exceed `n`, integer-divide `v` by 10 (pop a digit). Then add 1 (next sibling).

That is preorder on the 10-ary tree of prefixes. Recursive twin: from prefix `v`, try digits 0..9 as `10×v + d` when that value is at most `n` (skip `v = 0` as a start; roots are 1..9).

Sorting `str(i)` for i in 1..n is extra log and extra string memory — the follow-up forbids it. K-th Smallest in Lexicographical Order (440) counts how many numbers share a prefix; here you emit every number.

Do not write `1, 2, 3, …` then insert tens later by hand. Do not skip the “ends in 9 / past n” climb, or you stall at 19 when n is 25. Do not start at 0.

Time: O(n)  
Space: O(1) extra (answer is O(n))

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

Can `s2` be obtained by recursively splitting `s1` and optionally swapping the two halves? Same length. Length ≤ 30.

`great` vs `rgeat` → true. `abcde` vs `caebd` → false. `a` vs `a` → true.

## Split, maybe swap

Same letter counts are required, but not enough: `abcde` and `caebd` share a multiset and still return false. A scramble only swaps whole substrings from binary splits, not an arbitrary anagram, not Edit Distance operations, and not a subsequence.

`dfs(i, j, k)`: can `s1[i..i+k)` scramble into `s2[j..j+k)`? When `k == 1`, compare the two letters. For `k > 1`, try each cut `h`. Keep order: `dfs(i, j, h)` and `dfs(i+h, j+h, k-h)`. Swap: `dfs(i+h, j, k-h)` and `dfs(i, j+k-h, h)`. Cache the triple. Return `dfs(0, 0, n)` — a boolean.

**Time:** O(n^4)  
**Space:** O(n^3)

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

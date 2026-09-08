Same shortest-gap question as 243, but the dict is built once and `shortest(word1, word2)` is called up to 5000 times. `word1 ≠ word2`, both present. Dict length up to `3 × 10⁴`. Sample: `"coding"` vs `"practice"` → 3, then `"makes"` vs `"coding"` → 1.

## Map word → sorted indices, merge two lists

Rescanning the whole array on every query is 243 repeated: O(n) per call, too slow at 5000 times `3 × 10⁴`. III (245) is still a single scan, but allows the two words to be equal.

Constructor: for each index `i`, append `i` to `map[word]`. Each list is already increasing.

`shortest`: `a` and `b` are those two lists. Two pointers `i`, `j` from 0. While both in range: `ans = min(ans, abs(a[i] − b[j]))`, then advance the pointer at the **smaller** index (if equal, either side). The lists are sorted, so the closest unused pair for the lagging word is always the current other index. Nested `p × q` is unnecessary.

Do not store only the last index of each word (that is one query, not many). Do not assume a word appears once.

**Time:** O(n) construct; O(p + q) per `shortest`  
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

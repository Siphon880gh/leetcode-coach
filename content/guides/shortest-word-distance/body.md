Array `wordsDict` and two **different** words that both appear. Return the smallest index gap between a `word1` and a `word2`. Length up to `3 × 10⁴`. `["practice","makes","perfect","coding","makes"]`, `"coding"` vs `"practice"` → 3; `"makes"` vs `"coding"` → 1.

## Latest index of each, min gap

Shortest Word Distance II (244) answers many queries after a preprocess. III (245) allows `word1 == word2` (two distinct occurrences of the same word). Here the pair is distinct and you answer once.

`i = j = −1`. Scan `k`. If the word is `word1`, set `i = k`. If it is `word2`, set `j = k`. Once both are not `−1`, `ans = min(ans, abs(i − j))`. Because you always keep the **latest** hit of each, the closest opposite word so far is the previous other index. Nested every pair of positions is O(n²) and misses the limit.

Do not require the two words to be adjacent. Do not stop at the first pair — `"makes"` appears twice. Do not swap the words into a set-equality check like Valid Anagram.

**Time:** O(n)  
**Space:** O(1)

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

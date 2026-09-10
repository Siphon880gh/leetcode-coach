Array `words` of lowercase strings, length 2..1000, each word up to 1000. Return the max `len(i) × len(j)` for a pair that share **no** letter. None → `0`. `["abcw","baz","foo","bar","xtfn","abcdef"]` → 16 (`"abcw"` and `"xtfn"`). `["a","ab","abc","d","cd","bcd","abcd"]` → 4. `["a","aa","aaa","aaaa"]` → 0.

## One bit per letter; AND tests overlap

A nested scan of characters per pair is O(n² L). Encode the alphabet once: `mask[i] |= 1 << (c − 'a')`. Two words are disjoint iff `mask[i] & mask[j] == 0`. Then the product uses **full word lengths**, not unique-letter counts (`"aa"` still has length 2).

Walk `i`, build `mask[i]`, then compare against every `j < i`. Duplicate letters in one word set the same bit twice; that is fine.

Do not AND and then multiply unique-letter sizes. Do not treat overlapping `"ab"` / `"bc"` as legal. Do not skip the empty-product case (all words share a letter → 0).

**Time:** O(n² + L)  
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

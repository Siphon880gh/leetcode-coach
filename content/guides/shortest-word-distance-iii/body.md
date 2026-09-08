Same shortest-gap question as 243, except `word1` **may equal** `word2`. They still stand for two distinct occurrences. Dict length up to `10⁵`. `"makes"` vs `"coding"` → 1. `"makes"` vs `"makes"` → 3 (the two `"makes"` in the sample).

## Split on equality, or consecutive same-word indices

243 forbids `word1 == word2`. 244 is many queries with a preprocess. Here you answer once, and the equal case is legal.

If `word1 ≠ word2`: same as 243 — keep latest `i` and `j`, update `min abs(i − j)` whenever both exist.

If they are equal: keep the previous index `j` of that word. On each new hit `i`, `ans = min(ans, i − j)`, then `j = i`. That is the gap between **consecutive** occurrences; the nearest pair of the same word is always neighbors in the hit list.

Do not reuse 243’s two indices when the words match: setting both `i` and `j` to the same `k` would yield distance 0, which is one occurrence, not two. Do not require a WordDistance class.

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

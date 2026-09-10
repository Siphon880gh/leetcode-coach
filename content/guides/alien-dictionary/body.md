A list `words` claimed to be sorted in an unknown alphabet (lowercase English). Return any string of the unique letters in that alien order, or `""` if the list cannot be sorted that way. `["wrt","wrf","er","ett","rftt"]` → `"wertf"`. `["z","x"]` → `"zx"`. `["z","x","z"]` → `""`.

## Consecutive pairs become directed edges; then peel

Course Schedule II Kahn-peels courses. Here the nodes are letters that **appear**, and the edges come from **adjacent dictionary words**, not from a given prerequisite list.

For each consecutive pair, walk the shared prefix. If the earlier word is longer and the later word is a prefix of it (`["abc","ab"]`), the order is impossible — return `""`. At the first index where letters differ, add an edge `c1 → c2` (c1 must come before c2). If the reverse edge already exists, that is a cycle — `""`. Then Kahn: in-degree 0 letters into a queue, peel, append. If the answer is shorter than the number of distinct letters, a cycle remains — `""`. Any valid order is allowed.

Do not sort by English `a..z`. Do not compare only the first character of each word. Do not emit letters that never appear.

**Time:** O(total characters) to build edges, O(1) Kahn on at most 26 nodes  
**Space:** O(1) for a 26 × 26 graph

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

Integer array `nums`, length 1 to 5000, values −1000 to 1000. Count contiguous subarrays of length at least 3 whose consecutive differences are equal. `[1,2,3,4]` → 3 (`[1,2,3]`, `[2,3,4]`, `[1,2,3,4]`). `[1]` → 0.

## Extend a run; each new index adds that many slices

Walk adjacent pairs `(a, b)`. Keep the previous difference `d` (start with a sentinel outside the possible diffs, e.g. 3000) and a counter of how many extra triples currently end here. If `b − a` equals `d`, increment the counter; else set `d` to the new difference and reset the counter to 0. Then add the counter to the answer: a run of length `L` ending at this pair contributes `L − 2` slices that end here, which is exactly that counter.

A length-4 run `[1,2,3,4]` adds 1 when 3 lands, then 2 when 4 lands, total 3. Arithmetic Slices II (446) counts subsequences, not subarrays. Number of Zero-Filled Subarrays (2348) is the same “add the run length” idea on zeros.

Do not count non-contiguous subsequences. Do not require the whole array to be arithmetic. Do not skip slices shorter than the full run.

Time: O(n)  
Space: O(1)

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

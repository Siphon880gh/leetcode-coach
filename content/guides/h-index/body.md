Array `citations[i]` is cites for paper i. Return the largest `h` such that at least `h` papers have **at least** `h` citations each. `[3,0,6,1,5]` → `3`. `[1,3,1]` → `1`. Length 1..5000, cites 0..1000.

## Sort descending, or count and scan down

H-Index II (275) is the same definition on a **non-decreasing** array (binary search). Here the array is unsorted.

Sort descending. Then the first `h` papers are the most cited. `citations[h − 1] ≥ h` means paper number h (0-based index `h − 1`) still has at least `h` cites, so those `h` papers all meet the bar. Try `h` from `n` down to 1; first hit is maximum. None → `0`.

Counting: `h` cannot exceed `n`, so bucket `cnt[min(cites, n)]`. Walk `h` from `n` down, add `cnt[h]` into `s` (papers with at least `h` cites after clamping). First `s ≥ h` is the answer.

Do not average the cites. Do not require **exactly** `h` citations. Do not binary-search an unsorted array (that is 275’s extra assumption).

**Time:** O(n log n) sort, or O(n) counting  
**Space:** O(1) extra besides sort, or O(n) buckets

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

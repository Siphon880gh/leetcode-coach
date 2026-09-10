`citations` is **non-decreasing**. Same h-index as 274: largest `h` such that at least `h` papers have at least `h` cites. You must run in logarithmic time. `[0,1,3,5,6]` → `3`. `[1,2,100]` → `2`. n up to `10⁵`.

## Search h, not a paper index

H-Index (274) sorts or counts because the array is unsorted. Here the order is given. The last `h` papers are the most cited. They all meet the bar iff `citations[n − h] ≥ h` (0-based: the first of those last `h` papers).

Monotone: if `h` works, every smaller candidate works. Binary-search `h` on `[0, n]`. Use an upper-bound loop: `mid = (left + right + 1) >> 1`. If `citations[n − mid] ≥ mid`, raise `left` to `mid`; else drop `right` to `mid − 1`. Return `left`.

A twin searches the first index `i` with `citations[i] ≥ n − i`, then returns `n − i`.

Do not sort (already sorted; sorting would miss the log-time requirement). Do not scan every `h` from `n` down (that is 274). Do not binary-search as if the array were unsorted.

**Time:** O(log n)  
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

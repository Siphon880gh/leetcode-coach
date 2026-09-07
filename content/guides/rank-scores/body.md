`Scores` has `id` and `score` (two decimal places). Return `score` and `rank`, ordered by score high to low. Ties share a rank. After a tie, the next rank is the next integer — no holes. Sample: two 4.00s are both 1; 3.85 is 2 (not 3); two 3.65s are 3; 3.50 is 4.

## DENSE_RANK, not RANK, not ROW_NUMBER

Nth Highest Salary **picked** the row whose dense rank is N. Here you **emit** that dense rank for every score.

`DENSE_RANK() OVER (ORDER BY score DESC)`. Same score → same rank. The next distinct score takes the next integer. `RANK()` would leave holes (two 4.00s then 3.85 as 3). `ROW_NUMBER()` would split ties. Quote the alias: `` `rank` `` / `'rank'` — `rank` is reserved.

Pre-window walk: sort scores descending, keep `latest` and `rk`. Same as previous score → keep `rk`. New score → add 1. That is dense rank by hand.

Pandas: `score.rank(method="dense", ascending=False)`, drop `id`, sort score descending.

**Time:** O(n log n) to order  
**Space:** O(n) for the result (window state is O(1) extra beyond the sort)

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

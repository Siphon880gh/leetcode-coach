`Employee` has `id` and `salary`. Write `getNthHighestSalary(N)`: the Nth highest **distinct** salary, or `NULL` if fewer than N unique salaries. n = 2 on 100, 200, 300 → 200. n = 2 on a single 100 → null. Same table, n = 1 → 300.

## Parameterize Second Highest Salary

176 hardcoded “skip the max.” Here N is an argument. Unique salaries sorted descending; pick index N (1-based). Too few uniques → `NULL`.

MySQL `LIMIT`/`OFFSET` need a constant in older versions, so you cannot write `OFFSET N-1` as an expression. `SET N = N - 1` then `SELECT DISTINCT salary ORDER BY salary DESC LIMIT 1 OFFSET N`. Wrap that inner select in another `SELECT ( … )` so “no row at that offset” becomes `NULL` instead of an empty result. `OFFSET 0` is first (highest); after decrement, N = 2 skips one, same as 176’s `LIMIT 1, 1`.

Do not skip N minus 1 rows on the **raw** table: duplicate maxes would steal ranks. Window twin: `DENSE_RANK() OVER (ORDER BY salary DESC)` then `rk = N`.

Pandas: unique salaries, sort descending, if `N >= 1` and length at least N take index N minus 1, else `None`. Guard `N < 1` (offset would be nonsense).

**Time:** O(n log n) if you sort uniques; O(n) with a selection/`DENSE_RANK` plan  
**Space:** O(u) for unique salaries (or the rank window)

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

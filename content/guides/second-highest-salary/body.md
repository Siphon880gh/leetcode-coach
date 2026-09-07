`Employee` has `id` and `salary`. Return one column `SecondHighestSalary`: the second-highest **distinct** salary. If there is no such value (one unique salary, or empty), return `NULL` (`None` in Pandas). Example: 100, 200, 300 → 200. One row 100 → null. Two rows both 300 → null (no second distinct).

## Skip the max of the distinct set

Combine Two Tables keeps every Person with a left join. Here you need rank among unique numbers, not among rows.

Cleanest: `MAX(salary)` among rows whose salary is **strictly less than** `(SELECT MAX(salary) FROM Employee)`. Empty max is `NULL`. Ties at the top all drop out together, so 300, 300, 100 yields 100.

Same idea with skip: `SELECT DISTINCT salary … ORDER BY salary DESC LIMIT 1, 1` (MySQL: skip 1, take 1). Wrap that scalar in an outer `SELECT ( … ) AS SecondHighestSalary` so “no second row” becomes `NULL` instead of an empty result set. Do not `LIMIT 1 OFFSET 1` on the raw table without `DISTINCT` — two 300s would make the second row another 300.

Window twin: `DENSE_RANK() OVER (ORDER BY salary DESC)` then pick `rk = 2`. Dense rank shares 1 among tied maxes so the next distinct is 2. Plain `RANK()` would jump to 3 after two 300s.

Pandas: drop duplicate salaries, take the second of `nlargest(2)`, else `None`.

**Time:** O(n)  
**Space:** O(1) for the two-max scan (window rank uses extra)

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

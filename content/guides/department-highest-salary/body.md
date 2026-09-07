`Employee` has `id`, `name`, `salary`, `departmentId`. `Department` has `id`, `name`. For each department, every employee who holds that department’s highest salary (ties all stay). Columns: Department, Employee, Salary. Any order. Sample: IT Jim 90k and Max 90k; Sales Henry 80k. Joe 70k and Sam 60k drop.

## Groupwise max, not a global sort

Customers Who Never Order was an anti-join. Rank Scores ranked one list. Here the max is **per department**.

Join `Employee e` to `Department d` on `e.departmentId = d.id`. Keep rows whose `(departmentId, salary)` sits in `SELECT departmentId, MAX(salary) FROM Employee GROUP BY departmentId`. Jim and Max both match IT’s 90k.

Window twin: `RANK() OVER (PARTITION BY e.departmentId ORDER BY salary DESC)` then `rk = 1`. Ties at the top all get rank 1, so `RANK` and `DENSE_RANK` agree here. `ROW_NUMBER()` would keep only one of Jim/Max. Partition by department **id**, not a name that might collide.

Pandas: merge, `groupby(departmentId)['salary'].transform('max')`, keep salary equal to that max.

**Time:** O(n) with a hash max per department, then a pass  
**Space:** O(n) for the join / window

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

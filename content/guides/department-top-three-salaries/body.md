`Employee` has `id`, `name`, `salary`, `departmentId`. `Department` has `id`, `name`. A high earner has a salary in the top **three unique** salaries of that department. Return Department, Employee, Salary. Any order. Sample IT: Max 90k (1), Joe and Randy 85k (2), Will 70k (3); Janet 69k is out. Sales has only two unique salaries — both people stay. No two employees share the exact same name + salary + department.

## DENSE_RANK, not RANK, not “top three rows”

Department Highest Salary kept `rk = 1`. Here you keep `rk <= 3`, but the rank must be among **distinct** salaries.

`DENSE_RANK() OVER (PARTITION BY departmentId ORDER BY salary DESC)`. Same salary → same rank; the next distinct salary takes the next integer. Join Department for the name. Filter `rk <= 3`. IT: 90k is 1, both 85ks are 2, 70k is 3. `RANK()` would make 70k into 4 after two 85ks and drop Will. `ROW_NUMBER()` would split Joe and Randy.

Correlated twin: count **distinct** salaries in the same department that are strictly greater than this row’s salary; keep when that count is less than 3 (zero, one, or two higher unique values).

Pandas: unique `(salary, departmentId)`, take the three largest per dept, cutoff is the min of those; keep salary at least the cutoff.

**Time:** O(n log n) with a sort/window per department  
**Space:** O(n) for the window / join

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

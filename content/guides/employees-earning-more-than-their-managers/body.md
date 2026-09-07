`Employee` has `id`, `name`, `salary`, `managerId`. Return names of employees whose salary is strictly greater than their manager’s. Any order. Sample: Joe 70k reports to Sam 60k → Joe. Henry 80k reports to Max 90k → out. Sam and Max have `NULL` managerId → out.

## Same table twice: worker and boss

Consecutive Numbers joined three copies on **adjacent ids**. Here the join key is a foreign key: `e1.managerId = e2.id`. Alias `e1` as the worker, `e2` as the manager. `WHERE e1.salary > e2.salary`. Project `e1.name AS Employee`.

`INNER JOIN` is the right default: a `NULL` `managerId` matches no `id`, so the CEO row disappears. Do not `LEFT JOIN` and then compare to `NULL` salary. Combine Two Tables used a left join to **keep** unmatched people; this problem only cares about workers who have a manager.

Pandas: `merge` worker to employee again with `left_on="managerId"`, `right_on="id"`, then keep `salary > salary_manager`.

**Time:** O(n) with a hash on `id`  
**Space:** O(n) for the join

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

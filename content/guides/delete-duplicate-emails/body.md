`Person` has `id` and lowercase `email`. Delete duplicate emails, keeping the row with the smallest `id` for each address. Write a `DELETE`, not a `SELECT`. Pandas: mutate `Person` in place. Final order does not matter. Sample: ids 1 and 3 share `john@example.com` → keep 1, drop 3; keep `bob@example.com` id 2.

## Delete the larger id when the email matches

Duplicate Emails (182) only reports addresses that appear more than once. Second Highest Salary ranks values. Tenth Line prints one file line. Here the table itself must shrink.

Self-join: alias `p1` and `p2` on the same `email` with `p1.id < p2.id`, then `DELETE p2`. Every extra copy has a smaller id still in the table, so it is removed. Equivalent: delete ids that are not `MIN(id)` per email. MySQL will not let you `DELETE` from `Person` while grouping that same table in a subquery — wrap Person in a derived table, then `GROUP BY email`.

Pandas: sort by `id` ascending, `drop_duplicates` on `email` keeping the first row. Window twin: `ROW_NUMBER` partitioned by email ordered by id, delete `rk` greater than 1.

Do not keep the largest id. Do not `SELECT` the survivors and stop. Do not drop every john row.

**Time:** O(n) with a hash or index on email  
**Space:** O(u) unique emails for the min-id set (the join is O(n) extra in the worst pairing)

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

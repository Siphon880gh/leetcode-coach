`Customers` has `id`, `name`. `Orders` has `id`, `customerId` (FK to Customers). Names of customers with **no** order row. Any order. Sample: Joe and Sam ordered; Henry and Max did not.

## Anti-join, not “customers minus something by hand”

Duplicate Emails grouped a single table. Combine Two Tables left-joined to **fill** address. Here the left join is a filter: start from `Customers c LEFT JOIN Orders o ON c.id = o.customerId`, then `WHERE o.id IS NULL`. Unmatched customers have a NULL order primary key. Filter on `o.id`, not on `customerId` after an inner join — an inner join would drop the people you want.

`NOT IN (SELECT customerId FROM Orders)` is the same set when `customerId` is never NULL. A NULL inside a `NOT IN` list makes the predicate unknown for every row — prefer `NOT EXISTS` (correlated: no order with that `customerId`) if the subquery can contain NULL.

Pandas: customers whose `id` is not in `orders["customerId"]`.

**Time:** O(C + O) with a hash of order customer ids  
**Space:** O(O) for that set (or the join)

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

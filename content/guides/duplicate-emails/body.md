`Person` has `id` and `email` (lowercase, never `NULL`). Report emails that appear more than once. Any order. Sample: two `a@b.com` and one `c@d.com` → only `a@b.com`.

## Count per email, keep the repeats

Employees vs Managers joined two **roles**. Here you collapse rows that share a value.

`SELECT email FROM Person GROUP BY email HAVING COUNT(1) > 1`. `HAVING` runs after the group (unlike `WHERE`). `GROUP BY 1` means the first select list item — `GROUP BY email` reads clearer. `COUNT(1)` counts rows in the group.

Self-join twin: `p1.email = p2.email` and `p1.id != p2.id`, then `DISTINCT p1.email`. Two people with the same address prove a duplicate; three people would make several pairs, so `DISTINCT` again.

Pandas: `duplicated(subset=["email"])` then drop duplicate emails in the result.

**Time:** O(n) with a hash on email  
**Space:** O(u) unique emails

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

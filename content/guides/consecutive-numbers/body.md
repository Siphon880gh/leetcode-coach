`Logs` has autoincrement `id` starting at 1, and `num`. Return distinct numbers that appear on at least three **consecutive ids** with the same `num`. Sample: ids 1–3 are all 1 → `1`. Later 1s and pairs of 2s do not count. Any order.

## Adjacent ids, same num, three wide

Largest Number ordered string pieces. Here consecutiveness is the **id line**, not “appears three times anywhere.”

Self-join: alias `l1`, `l2`, `l3` with `l1.id = l2.id - 1` and `l2.id = l3.id - 1`, and `l1.num = l2.num = l3.num`. Project `DISTINCT l2.num AS ConsecutiveNums`. A run of four 1s makes several overlapping triples — `DISTINCT` keeps one row.

Window: `LAG(num)` and `LEAD(num)` **`OVER (ORDER BY id)`**. Keep rows where both neighbors equal `num`. Empty `OVER ()` is not a substitute for `ORDER BY id`.

Islands: when `num` differs from the previous row, start a new group; prefix-sum those starts; `GROUP BY` the group id `HAVING COUNT(1) >= 3`. Pandas: rolling window of 3 on `num`, keep where the three values are one unique.

**Time:** O(n) with a scan or indexed id joins  
**Space:** O(n) for the window / join working set

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

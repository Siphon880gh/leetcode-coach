`Weather` has unique `id`, unique `recordDate`, and `temperature`. Return ids whose temperature is strictly higher than the previous calendar day. Any order. Sample: 10, 25, 20, 30 on consecutive January dates → ids 2 and 4 (25 after 10, 30 after 20). Id 3 is cooler than the day before, so it is out.

## Date plus one, then compare temperatures

Delete Duplicate Emails joins two Person aliases on the same email. Combine Two Tables left-joins Address. Here the key is **yesterday**, not id.

Self-join `w1` to `w2` with `DATEDIFF(w1.recordDate, w2.recordDate) = 1` (or `SUBDATE(w1.recordDate, 1) = w2.recordDate`) and `w1.temperature > w2.temperature`. Select `w1.id`. Dates may skip; a gap of two days is not “yesterday.” Ids need not be consecutive, so `w1.id = w2.id + 1` is wrong.

Pandas: sort by `recordDate`, then keep rows where `temperature.diff() > 0` and the date diff is exactly one day; project `id`.

Do not compare to the globally previous row after sorting by id. Do not keep equal temperatures.

**Time:** O(n) with a hash on date  
**Space:** O(n) for the join or the sorted frame

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

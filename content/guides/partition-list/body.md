Partition a linked list so values < `x` come first, then values ≥ `x`. Keep each side’s original order. Up to 200 nodes.

`[1,4,3,2,5,2]`, `x = 3` → `[1,2,2,4,3,5]`. `[2,1]`, `x = 2` → `[1,2]`.

## Two chains, then join

A full sort would reorder 4, 3, 5 among themselves. Sort Colors mutates an array with three pointers. List II deletes duplicated values. Here you keep every node and stay stable.

Two dummy lists: left gets `val < x`, right gets `val ≥ x`. After the walk, set `tr.next = None` — the last ≥ `x` node still points into the old list and would cycle. Then `tl.next = r.next`. Empty left is fine. Return `l.next`, not the original `head` (the first node may belong on the right).

**Time:** O(n)  
**Space:** O(1)

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

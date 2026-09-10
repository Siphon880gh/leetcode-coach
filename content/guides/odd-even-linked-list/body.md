Singly linked list `head`. Group nodes at odd positions, then even positions, and return the new head. The first node is odd, the second even (1-based index). Order inside each group stays the same. `[1,2,3,4,5]` → `[1,3,5,2,4]`. `[2,1,3,5,6,4,7]` → `[2,3,6,7,1,5,4]`. Empty list stays empty. Must be O(n) time and O(1) extra space.

## Two tails, save the even head

This is not “odd values then even values.” Partition List (86) splits on a numeric threshold. Here the split is index. Copying into an array then rebuilding is O(n) space and fails the constraint.

Keep `a` as the odd tail (`head`), `b` as the even tail (`head.next`), and `c` as the even head (same as initial `b`). While `b` and `b.next` exist: hang the next odd on `a` and step `a`; hang the next even on `b` and step `b`. Then `a.next = c` so the odd chain feeds the even chain. Return `head` (odd head never moved). One or two nodes: the loop never runs, or `b` is null; still set `a.next = c`.

Do not sort by `node.val % 2`. Do not allocate a second list of nodes. Do not drop the even head `c` before the final join.

Time: O(n)  
Space: O(1)

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

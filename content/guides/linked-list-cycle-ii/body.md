Return the node where the cycle starts, or `None`. Do not modify the list. `pos` is not an input. `[3,2,0,-4]` cycle into index 1 → that node. `[1]` acyclic → `None`.

## Meet, then walk from head

Cycle I only asks existence. The Floyd meeting point is usually inside the ring, not the entrance — they can meet anywhere on the cycle. A hash of nodes works but uses extra memory. Copy List’s map and Word Break’s `f[n]` are different problems. Do not cut `next` at the meet, and you do not need to measure the ring.

Same first loop as Cycle I: `slow` steps 1, `fast` steps 2. If `fast` hits `None`, return `None`. On meet: `ans = head`; while `ans != slow`, both step 1; return `ans`. After a meet, the distance from head to the entrance equals the remaining walk around the ring (mod ring length): `slow` sits `y` into the ring; head is `x` before the ring; those distances meet at the entrance. `slow` is not already the entrance because fast lapped it there.

Return the entrance `ListNode` (or `None`), not a boolean and not `pos`.

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

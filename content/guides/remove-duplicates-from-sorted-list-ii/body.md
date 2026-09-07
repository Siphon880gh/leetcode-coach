Sorted linked list: delete every node whose value appears more than once. Up to 300 nodes.

`[1,2,3,3,4,4,5]` → `[1,2,5]`. `[1,1,1,2,3]` → `[2,3]`.

## Drop every duplicated value

Problem 83 keeps a single copy. Array II keeps two copies in a vector. Remove Nth Node from End uses a fixed gap. Here any duplicated number is removed entirely.

`dummy.next = head`. Walk `cur` across equals. If `pre.next == cur`, the node is unique — move `pre`. Else `pre.next = cur.next`. Then `cur = cur.next`. A dummy is required because the first nodes may all be duplicates; `dummy.next` is the new head. Return that list, not an integer `k`.

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

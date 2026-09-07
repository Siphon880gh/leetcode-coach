Return true if the list has a cycle. `pos` is not an input. `[3,2,0,-4]` with a cycle into index 1 → true. `[1]` acyclic → false. Follow-up: O(1) extra memory.

## Floyd: meet or run off the end

Linked List Cycle II asks for the entrance node. Duplicate values are allowed without a cycle, so a set of values is wrong. A set of node identities works but uses O(n) extra. Copy List’s random map is a different problem. You are not given `n` as an integer to count past.

`slow = fast = head`. While `fast` and `fast.next`: `slow` steps 1, `fast` steps 2; if they are the same node, return true. Else return false when `fast` hits null. Check `fast.next` before two steps so `fast.next.next` does not crash on the last node of an acyclic list. They start equal, then you move before comparing, so a one-node acyclic list returns false. Starting `fast` one step ahead is optional, not required.

Return a boolean, not the meeting node.

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

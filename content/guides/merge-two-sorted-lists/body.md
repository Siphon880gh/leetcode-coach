Both lists are sorted non-decreasing. Splice their nodes into one sorted list (reuse nodes, do not allocate new value nodes). Empty lists are allowed.

`[1,2,4]` and `[1,3,4]` → `[1,1,2,3,4,4]`. Two empties → `[]`. One empty and `[0]` → `[0]`.

## Dummy tail (iterative)

Dummy plus a `cur` pointer. While both lists are live, attach the smaller head to `cur.next` and advance that list. Then `cur.next = list1 or list2` (the remainder). Return `dummy.next`. O(1) extra memory besides the output chain.

## Recursion

If either list is null, return the other. Else attach the smaller head to `merge(that.next, other)` and return that head. Same O(m+n) time; call stack is O(m+n).

**Time:** O(m + n)  
**Space:** O(1) iterative, O(m + n) recursive

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

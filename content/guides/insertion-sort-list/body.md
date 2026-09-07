Sort a singly linked list by insertion sort. `[4,2,1,3]` → `[1,2,3,4]`. `[-1,5,3,4,0]` → `[-1,0,3,4,5]`. Up to 5000 nodes.

## Splice into a growing sorted prefix

The problem asks for insertion sort on the list, not n log n merge (that is Sort List) and not copying values into an array. Reorder List’s weave and LRU’s map are different problems. Swap Pairs only exchanges neighbors once; insertion sort may move a node many places left.

Dummy pointing at `head` (`dummy = Node(head.val, head)`). `pre, cur = dummy, head`. If `pre.val <= cur.val`, just advance. Else scan `p` from dummy while `p.next.val <= cur.val`, then splice: `t = cur.next`; `cur.next = p.next`; `p.next = cur`; `pre.next = t`; `cur = t`. After splicing, `cur` is the saved next, not `pre.next`, because `pre` still marks the last sorted node.

Return `dummy.next`, not `dummy`. Dummy copies the first value only as a sentinel; returning it duplicates that value. Empty or one node returns `head`.

**Time:** O(n²)  
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

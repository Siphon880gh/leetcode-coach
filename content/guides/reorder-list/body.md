Reorder in place to L0 → Ln → L1 → Ln-1 → … . Do not rewrite `node.val`. Void return. `[1,2,3,4]` → `[1,4,2,3]`. `[1,2,3,4,5]` → `[1,5,2,4,3]`. `n` up to 5e4.

## Split, reverse, weave

The statement forbids changing `val`. Swap Pairs is `1-2-3-4` → `2-1-4-3`, not `1-4-2-3`. A full reverse is n…0. Cycle I/II’s meet finds a loop, not this cut. Copy List’s map is extra space and a new list. Rotate List keeps order, just a new start — this function is void: keep the original head.

`fast = slow = head`. While `fast.next` and `fast.next.next`: slow one, fast two. Then `cur = slow.next`; `slow.next = None`. Reverse `cur` into `pre`. This stop condition leaves `slow` at the last node of the front half so you can cut before reversing. Cycle I’s `fast and fast.next` can land `slow` on the first node of the back half and the weave duplicates or drops a node.

Second half reversed is Ln, Ln-1, … which you splice after each front node: while `pre`: `t = pre.next`; `pre.next = cur.next`; `cur.next = pre`; `cur, pre = pre.next, t`. `head` still starts the list. Do not return `pre` (that would start at Ln). Do not return a value.

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

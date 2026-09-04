k sorted lists, merge into one sorted list by splicing nodes. k and total nodes are at most 10⁴. Empty `lists` or empty inner lists → `[]`.

`[[1,4,5],[1,3,4],[2,6]]` → `[1,1,2,3,4,4,5,6]`.

Naive merge-two-at-a-time from the left is O(k n) in the worst case. Need log k.

## Min-heap of heads

Put every non-null list head in a min-heap keyed by `val`. Dummy + `cur`. While the heap is non-empty: pop the smallest node, attach it to `cur`, and if `node.next` exists push that. Heap size stays ≤ k.

In Python, define `ListNode.__lt__` by `val` so the heap can store nodes directly.

Divide-and-conquer (merge lists[i] with lists[j] in pairs, like merge sort) is the same O(n log k) without a heap.

**Time:** O(n log k)  
**Space:** O(k) for the heap

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

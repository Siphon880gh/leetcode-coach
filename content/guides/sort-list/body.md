Sort a linked list ascending. `[4,2,1,3]` → `[1,2,3,4]`. Up to 5e4 nodes, so O(n²) Insertion Sort List is too slow. Empty list is `[]`. Follow-up: O(n log n) time.

## Split, recurse, merge

Insertion-sort splices are O(n²). Sort Colors is an array Dutch flag. Reorder List does not sort. Copying to an array uses extra O(n) and is not the list merge-sort path. Merge Two Sorted Lists needs two already-sorted lists; one unsorted list is not that input.

`slow = head`, `fast = head.next`. While `fast` and `fast.next`, advance slow by 1 and fast by 2. Then `l2 = slow.next`; `slow.next = None`. Recurse on `head` and `l2`; merge with a dummy tail taking the smaller val. On two nodes, fast at `head` would put both in one half and recurse forever. Cycle I starts both at `head` to look for a meeting, not a midpoint cut — here fast must start one step ahead so a two-node list splits 1+1.

Must cut `slow.next` or the halves share a tail and recurse forever. `[]` and a single node return as-is. Recursion returns new heads. Dummy is a sentinel; the sorted list starts at `dummy.next`.

**Time:** O(n log n)  
**Space:** O(log n) stack

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

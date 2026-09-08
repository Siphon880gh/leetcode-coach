Singly linked list. You receive only the node to delete — **not** `head`. Values unique. `node` is in the list and **not** the tail. After the call, that value is gone, length drops by one, order of the other values stays. `[4,5,1,9]`, delete `5` → `[4,1,9]`. Same list, delete `1` → `[4,5,9]`. Length 2 to 1000.

## Overwrite this node with its successor

Remove Linked List Elements (203) walks from a dummy `head` and skips matches. Reverse Linked List rewires the whole chain. Palindrome Linked List reverses the right half. Here you cannot find the previous pointer, so you cannot `prev.next = node.next`.

Copy `node.next.val` into `node.val`, then `node.next = node.next.next`. The next object is unlinked; the given object now holds the old next value. Do not `return` a new head (the function is void). Do not walk from a fictional `head`. Do not try this on a tail (the problem forbids it: there is no next to copy).

**Time:** O(1)  
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

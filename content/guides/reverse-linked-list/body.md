Reverse a singly linked list and return the new head. Up to 5000 nodes. `[1,2,3,4,5]` → `[5,4,3,2,1]`. `[1,2]` → `[2,1]`. Empty → empty. Follow-up: iterative and recursive.

## Head insertion, or prev walking the chain

Reverse List II flips a closed interval and stitches prefix and suffix. Remove Linked List Elements skips matches. Here the whole chain flips. Do not copy values into a new list of nodes unless you must; rewire `next`.

Iterative (head insertion): empty `dummy`. `curr = head`. While `curr`: save `nxt = curr.next`, set `curr.next = dummy.next`, hang `curr` as `dummy.next`, then `curr = nxt`. Each node is pushed to the front of the growing reversed prefix. Return `dummy.next`. Twin: `prev = None`, `curr = head`, same save-rewire-advance, return `prev`. Save `nxt` **before** you overwrite `curr.next`.

Recursion: reverse the suffix first; the old tail is the new head. Then `head.next.next = head` and `head.next = None` so the old head becomes the new tail. Base: empty or one node. O(n) stack.

Do not reverse only the first two nodes. Do not leave the original head pointing into the reversed prefix (cycle). Empty input is already reversed.

**Time:** O(n)  
**Space:** O(1) iterative, O(n) recursive stack

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

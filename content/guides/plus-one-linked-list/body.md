Non-negative integer as a singly linked list, most significant digit at `head`. Plus one. Length 1..100, no leading zeros except `0` itself. `[1,2,3]` → `[1,2,4]`. `[0]` → `[1]`. All nines grow a new head (`[9,9]` → `[1,0,0]`).

## Last node that is not 9

Dummy `0` whose next is `head`. Walk once and keep `target` as the last node whose value is not 9 (starts as dummy). Then `target.val += 1` and set every node after `target` to 0. If dummy is now 1, every original digit was 9 — return dummy; else return dummy.next.

That is the same carry as Plus One (66) without an array: the carry dies at the rightmost non-nine, and the suffix of nines becomes zeros. Reverse, add from the new head, reverse again also works, but needs two extra list walks and care on a new node.

Do not join the list into a machine int. Add Two Numbers (2) stores the least significant digit at the head; here the head is the high digit. Do not mutate only the tail node when it is 9.

Time: O(n)
Space: O(1) besides the optional new head

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

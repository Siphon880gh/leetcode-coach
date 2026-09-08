Singly linked list. True iff the node values read the same forward and backward. `[1,2,2,1]` → true. `[1,2]` → false. Length 1 to `10⁵`. Follow-up: O(n) time, O(1) extra space.

## Midpoint, reverse, two-pointer match

Palindrome Number reverse-digits an integer. Reverse Linked List flips an entire chain. Copying every value into an array then checking two indices is O(n) extra and fails the follow-up.

Slow starts at `head`, fast at `head.next` (or both at `head` with a slightly different stop). While fast can take two steps, slow takes one. `slow` lands at the last node of the left half. Reverse `slow.next` with the usual save-`nxt`-rewire (`prev` walking). Then walk `pre` (new head of the reversed right) against `head`: if any `val` differs, false. Odd length leaves the middle unused on the left; the reversed half is shorter, so the compare loop stops when `pre` is null. Do not reverse the whole list and expect to still walk from the original head (you lost the left half). Do not skip reversing and try to walk backward (no `prev` pointer).

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

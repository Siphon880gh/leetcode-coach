Return the first node shared by `headA` and `headB`, or null. Lists have no cycles. Same value is not enough: in `[4,1,8,4,5]` and `[5,6,1,8,4,5]` the two 1s are different objects; they meet at the 8. Example 3 (`[2,6,4]` and `[1,5]`) has no shared node. Keep the original structure. `m`, `n` up to 3×10⁴.

## Switch lists at null so both walk m plus n

Floyd is for a cycle; these lists have none. Matching `val` is wrong (two 1s). A set of A’s nodes is O(m) extra; the follow-up wants O(1). Lockstep from the heads also fails when `skipA` and `skipB` differ.

Two pointers: when `a` dies, jump to `headB`; when `b` dies, jump to `headA`; stop when `a == b`. `while a != b: a = a.next if a else headB; b = b.next if b else headA`. Return `a`. After the switch, leftover prefixes cancel: both have walked the same length.

If the lists never join, both become null at the same step, so you return null. In Python and Java, null equals null, so the loop stops. They do not spin forever.

Example 1 meets at the node whose value is 8 (identity, not the 1s). Example 3 is disjoint. Not LC 159’s window.

**Time:** O(m + n)  
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

Delete the nth node from the **tail** and return the new head. `n` is always in range. `[1,2,3,4,5]`, n = 2 → `[1,2,3,5]`. Single node, n = 1 → `[]`.

A two-pass count-then-index works; the follow-up is one pass.

## Dummy and a lead of n

Put a dummy in front of `head` so deleting the first real node is the same splice. Set `fast = slow = dummy`. Move `fast` n steps (it now sits on the nth node from the start). Then walk both until `fast.next` is null: `slow` lands on the predecessor of the nth-from-end node. `slow.next = slow.next.next`. Return `dummy.next`.

**Time:** O(sz)  
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

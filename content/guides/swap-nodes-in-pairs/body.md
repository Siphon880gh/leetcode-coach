Swap every two adjacent nodes; do not swap `val`. Length 0..100. `[1,2,3,4]` → `[2,1,4,3]`. `[1,2,3]` → `[2,1,3]`. Empty or one node is unchanged.

## Recursion

If `head` or `head.next` is null, return `head`. Recurse on the rest after the pair (`head.next.next`). Let `p = head.next`. Point `p.next` at `head`, `head.next` at the recursive result. Return `p` (new pair head). Stack is O(n).

## Dummy iterative

Dummy in front of `head`. `pre` starts at dummy. While `pre.next` and `pre.next.next` exist: `a = pre.next`, `b = a.next`. Rewire `pre.next = b`, `a.next = b.next`, `b.next = a`, then `pre = a`. O(1) extra memory.

**Time:** O(n)  
**Space:** O(n) recursive, O(1) iterative

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

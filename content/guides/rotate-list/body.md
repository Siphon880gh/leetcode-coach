Rotate a singly linked list **right** by k places. k can be 2×10⁹. n ≤ 500. Empty or a single node stays as-is.

`[1,2,3,4,5]`, k = 2 → `[4,5,1,2,3]`. `[0,1,2]`, k = 4 → `[2,0,1]`.

## k mod n, then a gap of k

Count n first, then `k %= n`. A full turn is a no-op; walking 2×10⁹ steps would TLE. If k becomes 0, return `head`.

Let `fast` walk k nodes ahead of `slow`. Then move both until `fast.next` is null. `slow` now sits just before the new head. Cut `slow.next`, hang the old `head` off `fast` (the old tail).

This is not Rotate Image (a square matrix) and not Reverse Nodes in k-Group (window reverses). A value-array rotate plus rebuild also works but wastes extra space; the writeup only rewires three pointers.

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

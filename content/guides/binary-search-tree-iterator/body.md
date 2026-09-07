In-order iterator on a BST: `next()` and `hasNext()`. Constructor pointer starts before the smallest, so the first `next` is the min. Calls to `next` are always valid. Sample tree `[7, 3, 15, null, null, 9, 20]`: next yields 3, 7, then hasNext true, then 9, 15, 20, then hasNext false. Up to 10⁵ nodes and 10⁵ calls. Follow-up: average O(1) per call and O(h) memory.

## Left spine on a stack; after a pop, push the right’s left spine

Flattening the whole inorder list in the constructor is O(n) extra, not O(h). Factorial trailing zeroes is counting 5s. Excel column number is base-26. Recursing the whole tree up front also spends O(n) before any `next`.

Constructor: walk left from `root`, pushing every node. `hasNext` is whether the stack is nonempty. `next`: pop; that value is the answer; then from the popped node’s right, walk left pushing as you go. Each node is pushed and popped once, so amortized O(1) per `next`. Height of the stack is O(h).

The sample’s first pop is 3 (left of 7). After popping 7 you push 15, then 9, so the next value is 9, not 15.

**Time:** O(1) amortized per `next` / `hasNext`  
**Space:** O(h)

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

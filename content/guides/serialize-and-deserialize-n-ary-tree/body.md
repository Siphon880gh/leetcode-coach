N-ary tree, 0 to 1e4 nodes, height at most 1000. Encode to a string and decode back to the same tree. The codec must be stateless. Empty root → empty string / null.

## BFS: children of a node, then `#`

Serialize: if root is null, return empty. Start with the root value in a queue. While the queue is nonempty, dequeue, append each child’s value (and enqueue those children), then append `#` so the decoder knows that sibling list is done. Join with commas.

Deserialize: split. First token is the root. For each dequeued node, read tokens as children until `#`, enqueue those children, then skip the `#`.

Serialize and Deserialize Binary Tree (297) plants a null for a missing left or right child; here the child count is variable, so a terminator is simpler than padding. Encode N-ary Tree to Binary Tree (431) is a different left-child / right-sibling encoding. N-ary Tree Level Order Traversal (429) only returns values by level — it does not have to round-trip.

Do not keep a global cursor on the Codec class. Do not omit `#` after a leaf (the decoder would eat the next node’s tokens). Do not treat the LeetCode input array with `null` level breaks as the only legal string format.

Time: O(n)  
Space: O(n)

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

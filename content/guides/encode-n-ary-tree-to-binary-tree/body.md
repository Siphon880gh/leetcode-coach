N-ary tree, 0 to 1e4 nodes, height at most 1000. Encode it as a binary tree and decode back to the original. The codec must be stateless. Empty → empty.

## Left is first child, right is next sibling

Encode: copy the value. If there are no children, stop. Otherwise set `left` to the encoding of the first child. Then walk the remaining children: each one’s encoding hangs off the previous encoded child’s `right` (sibling chain).

Decode: copy the value into an N-ary node. If `left` is null, there are no children. Else start at `left` and walk `right`: each node on that chain is one child (decode recursively).

Serialize and Deserialize N-ary Tree (428) writes a string with `#` terminators. Serialize and Deserialize Binary Tree (297) uses nulls for missing left/right. N-ary Tree Level Order (429) only lists values. Do not put every child under `left` as a nested left spine — siblings must be a right chain so decode can recover order. Do not store the child list on the Codec instance.

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

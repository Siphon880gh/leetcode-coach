Square grid of 0/1, side n a power of two (1 to 64). Build a quad tree: a node is a leaf when its rectangle is uniform; otherwise it has four children (top-left, top-right, bottom-left, bottom-right). `[[0,1],[1,0]]` is mixed, so the root is not a leaf and each 1 by 1 cell is a leaf.

## Leaf if uniform, else four quadrants

On rectangle `[a..c] × [b..d]`, scan for both a 0 and a 1. If only one value appears, return `Node(that value, isLeaf=true)`. Else split at the mid row and mid column and recurse. `val` on an internal node can be anything (the judge ignores it).

Quad Tree Intersection (558) merges two already-built trees. Maximum Length of a Concatenated String with Unique Characters (1239) is unrelated backtracking. Do not emit four children when the block is uniform. Do not skip a 1 by 1 cell — it is always a leaf. Do not require n to be odd; n is always 2^x.

Time: O(n² log n) if each rectangle is scanned fully  
Space: O(n²) nodes in the worst mixed grid, plus O(log n) recursion

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

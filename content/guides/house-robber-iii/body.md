Binary tree of houses; the root is the only entrance. If you rob a node you cannot rob its parent or its children. Return the maximum total. `[3,2,3,null,3,null,1]` → 7 (root 3 plus the two grandchildren 3 and 1). `[3,4,5,1,3,null,1]` → 9 (the two children 4 and 5). Up to 1e4 nodes; values are non-negative.

## Each node returns two numbers

198 / 213 are a line or a circle. Here adjacency is the parent–child edge, so a post-order pair is enough.

`dfs(node)` → `(take, skip)`:

- `take` = `node.val` plus `skip` of the left child plus `skip` of the right child (both children must be skipped).
- `skip` = the better of take/skip on the left, plus the better of take/skip on the right (children are independent).
- Null → `(0, 0)`.
- Answer = the better of take/skip at the root.

Do not take every other level as a block (a rich child can beat its parent, or two grandchildren can beat one parent). Do not run 198 on a level-order array. Memoizing `rob(node)` vs `rob(node)` with a “parent robbed” flag is the same DP; the pair return is the compact form.

Time: O(n)  
Space: O(h) recursion (O(n) worst case)

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

Is the tree height-balanced — every node’s two subtree heights differ by at most 1? Up to 5000 nodes.

`[3,9,20,null,null,15,7]` → true. `[1,2,2,3,3,null,null,4,4]` → false. Empty → true.

## Height or -1 if a tilt

Max Depth returns a number. Convert Sorted Array builds a tree. Validate BST checks order. Unique BST I counts trees. Balance is about heights, not values.

`height(None) = 0`. Else compute `l` and `r`. If `l == -1` or `r == -1` or `abs(l - r) > 1`, return `-1`. Else return `1 + max(l, r)`. Checking only the root misses a deeper tilt (example 2). Calling a separate max-depth from every node repeats work and can be O(n²); a `-1` bubbles up in one O(n) walk. Return `height(root) ≥ 0` — a boolean, not the height integer.

**Time:** O(n)  
**Space:** O(n)

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

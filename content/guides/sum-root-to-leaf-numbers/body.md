Each root-to-leaf path is a **decimal number**; return their sum. Digits 0–9, at least one node, depth at most 10.

`[1,2,3]` → `12+13=25`. `[4,9,0,5,1]` → `495+491+40=1026`.

## Carry `s × 10 + val`, add at a true leaf

Path Sum I is a boolean; Path Sum II returns lists of values added along the way. Max Path Sum can bend left+node+right. Here `1-2` is the integer `12`, not `3`. Min Depth, Flatten, and Longest Consecutive do not fold digits into a base-10 number.

`dfs(None) = 0`. Else `s = s × 10 + val`. If **both** children are missing, return `s`. Otherwise return `dfs(left, s) + dfs(right, s)`. A missing child contributes 0, so a node with one child is **not** a leaf — it is still a prefix. Treating `4` as both `4` and `40` would double-count; only a node with no children closes a number.

Return the integer sum — `25` and `1026` — not true/false, not `[[1,2],[1,3]]`, and not the max `13`.

**Time:** O(n)  
**Space:** O(h) for the call stack (depth ≤ 10)

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

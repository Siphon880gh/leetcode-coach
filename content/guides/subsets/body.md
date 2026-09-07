Return all subsets of unique `nums` (the power set). n ≤ 10. Do not emit both `[1,2]` and `[2,1]`.

`[1,2,3]` includes `[]` and `[1,2,3]`. `[0]` → `[[],[0]]`.

## Skip or take, record at the end

Combinations asked for one `k`. Here every length is required, including the empty list. Record once per finished scan, not at a fixed size. A permutation tree would emit both orders; the index only moves forward. Subsets II later skips duplicates after a sort — these `nums` are unique.

`dfs(0)`: if `i == n`, append a copy of `t` (the list is popped on the way back). Else recurse without `nums[i]`, then append, recurse, pop. The skip-first branch produces `[]`. Return all 2^n subsets, including the empty set.

**Time:** O(n × 2^n)  
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

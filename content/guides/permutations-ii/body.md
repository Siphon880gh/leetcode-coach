`nums` may contain duplicates. Return each **unique** permutation once. n ≤ 8.

`[1,1,2]` → `[[1,1,2],[1,2,1],[2,1,1]]`. Distinct `[1,2,3]` is the same six lists as Permutations.

## Skip an unused twin

Same `dfs(i)` / `vis[j]` skeleton as Permutations: fill slot `i` with an unused index. After sorting, equal values sit next to each other.

When you consider `j`, skip if `j > 0` and `nums[j] == nums[j-1]` and `vis[j-1]` is **false**. That means the previous twin was not chosen at an earlier slot, so taking this `j` now would recreate a branch the earlier twin already owns. If `vis[j-1]` is true, this `j` is the second `1` in `[1,1,2]` and must be allowed.

Deduping the finished lists with a set also works but wastes the duplicate work. Combination Sum II skips twins at the **same loop depth** (`j > i`). Here the skip is “left twin unused,” because every unused index is a candidate at every depth.

**Time:** O(n × n!) worst case  
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

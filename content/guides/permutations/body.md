`nums` are distinct. Return every ordering. n ≤ 6, so n-factorial answers (at most 720) fit.

`[1,2,3]` → the six orderings. `[1]` → `[[1]]`.

## Fill unused indices

Build a path of length n. `dfs(i)` fills position `i`. A boolean `vis[j]` means index `j` is already on the path.

- `i == n` → copy the path into the answer.
- Else for each `j` with `vis[j]` false: mark `j`, put `nums[j]` at slot `i`, recurse `i + 1`, unmark.

Because values are unique, two different indices never hold the same number, so you do not skip “twins.” Permutations II needs that skip after sorting.

Swapping `nums[i]` with each later `nums[k]` in place is the same tree without a `vis` array: the prefix `0..i-1` is already chosen, the suffix is the unused pool.

**Time:** O(n × n!) — n! paths, O(n) to copy each  
**Space:** O(n) for the path and `vis`

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

Power set of `nums` that may contain duplicates; unique subsets only. n ≤ 10.

`[1,2,2]` → `[[],[1],[1,2],[1,2,2],[2],[2,2]]`. `[0]` → `[[],[0]]`.

## Sort, then skip twins

Subsets assumed unique nums — two 2s would emit `[2]` twice. Combination Sum II skips twins but filters by a target. Permutations II lists orderings. Gray Code is a bit sequence. Combinations asks for one `k`.

Sort first so equals sit together. `dfs(i)`: if `i == n`, copy `t` (includes `[]`). Else take `nums[i]`, recurse, pop. Then while the next values equal it, `i += 1`, then `dfs(i + 1)`. Without a sort, the while-loop cannot skip the twin skip-branch. Return the unique power set in any order.

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

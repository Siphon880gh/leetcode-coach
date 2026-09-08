True if some value appears at two **distinct** indices `i`, `j` with `abs(i − j) ≤ k`. `n` and `k` up to `10⁵`. `[1,2,3,1]`, `k = 3` → true. `[1,0,1,1]`, `k = 1` → true. `[1,2,3,1,2,3]`, `k = 2` → false (the repeats sit 3 apart).

## Last index, not “any duplicate”

Contains Duplicate (217) is a yes if the value appears **anywhere**. Contains Duplicate III (220) also bounds the **value** gap. Here the extra constraint is only the index window.

Map value → last index seen. At `i`: if `x` is in the map and `i − last ≤ k`, return true. Then write `map[x] = i` even on a far-away earlier copy, so later probes use the closest previous index. A set of “seen anywhere” is 217 and would accept `[1,2,3,1,2,3]` with `k = 2`. Nested loops are O(n²) and miss the limit.

Sliding window of length `k + 1`: a set of values in `nums[i − k .. i]`. If `nums[i]` is already in the set, true; else add it, and if `i ≥ k` drop `nums[i − k]`. Same O(n) time; the map of last indices is the usual write-up.

Do not require the two copies to be adjacent (`k = 1` only). Do not return the indices — only the boolean. `k = 0` with distinct `i`, `j` is always false.

**Time:** O(n)  
**Space:** O(n) (or O(min(n, k)) for the window set)

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

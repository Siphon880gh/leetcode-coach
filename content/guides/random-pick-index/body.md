`nums` may have duplicates. `pick(target)` returns one index `i` with `nums[i] == target`, each such index equally likely. The target is guaranteed to appear. `n` up to `2 × 10⁴`, at most `10⁴` picks. Example: `[1, 2, 3, 3, 3]`, `pick(3)` is `2`, `3`, or `4` with equal chance; `pick(1)` is always `0`.

## Count matches as you walk; swap the answer with chance `1/k`

Keep a counter `k` of how many times you have seen `target`. When you hit the `k`-th match, draw an integer from `1` to `k` inclusive and, if it equals `k`, set the answer to this index. The first match always wins (`1/1`). The second keeps or replaces with `1/2`. After `k` matches, every earlier index still has probability `1/k`.

A map from value to a list of indices also works (`O(n)` space, `O(1)` pick after a random index into that list). Reservoir needs only `O(1)` extra space besides storing `nums`, and it still works if `nums` is a stream you cannot index twice.

Linked List Random Node (382) is the same replace-with-`1/k` walk. Insert Delete GetRandom (380) needs a map plus a swap-delete array so `getRandom` is uniform over the live set. Shuffle an Array (384) permutes the whole array; it does not pick one matching index.

Do not return the first match every time. Do not pick a random index in `0..n−1` and hope it equals `target`. Do not treat this as Weighted Random Pick (528): here every matching index has the same weight.

Time: O(n) per pick  
Space: O(1) extra (reservoir) or O(n) (index lists)

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

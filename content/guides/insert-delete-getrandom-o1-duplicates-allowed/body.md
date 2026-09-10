`RandomizedCollection` is a multiset. `insert(val)` always stores a new copy and returns true only when `val` was missing. `remove(val)` drops one copy if any exist. `getRandom()` picks uniformly from the bag, so copies weigh more: insert 1, 1, 2 then 1 with probability 2/3. Average constant time. At most about 2×10^5 mixed calls. `getRandom` is never called on empty.

## List plus value → set of indices

Keep `l` (every copy in order) and `m[val]` a set of indices into `l`. Insert: add `len(l)` to `m[val]`, append, return whether that set just became size 1.

Remove: if `val` is missing, false. Take any index `i` of `val`. Copy the last value into slot `i`, then update index sets: drop `i` from `val`, drop the old last index from the moved value, and if `i` was not last, add `i` to the moved value. Pop `l`. If `val`’s set is empty, delete the key. When `val` is also the last value, those two sets are the same object — drop `i` first, then drop the last index, then add `i` back only if the hole was not already last.

Uniform `getRandom` is a random index into `l`, not a random key of `m`.

Insert Delete GetRandom without duplicates (380) stores one index per value. A single integer in the map cannot track two copies of 1. Sampling unique keys would give 1 and 2 equal weight after [1, 1, 2].

Do not skip the index-set update when the swapped-in last equals `val`. Do not return true on a duplicate insert (the copy still goes in). Do not scan `l` to remove.

Time: O(1) average per insert / remove / getRandom
Space: O(n)

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

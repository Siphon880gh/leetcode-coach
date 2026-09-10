Implement `RandomizedSet`: `insert(val)` true iff it was new, `remove(val)` true iff it was present, `getRandom()` a uniform member (the set is never empty on that call). Average constant time per op. Example: insert 1, remove 2 (false), insert 2, getRandom is 1 or 2, remove 1, insert 2 (false), getRandom is 2. At most about 2×10^5 mixed calls.

## List plus value → index

Keep `q` (the values) and `d` (index of each value in `q`). Insert: if `val` is already in `d`, false; else `d[val] = len(q)`, append, true.

Remove: if `val` is missing, false. Let `i = d[val]`. Copy the last value into slot `i`, set `d[last] = i`, pop `q`, delete `val` from `d`. If `val` was already last, the swap is a no-op and still works. Uniform `getRandom` is a random index into `q`.

A hash set alone has no O(1) uniform pick. An array alone makes `remove` a scan. Erasing a middle index without the swap-with-last trick is linear. Insert Delete GetRandom with duplicates (381) stores a bag of indices per value. Phone Directory (379) is a pool of free integers, not a random used member.

Do not drop the last value’s map entry when it moved into `i`. Do not treat a duplicate `insert` as true. `getRandom` must not walk the map.

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

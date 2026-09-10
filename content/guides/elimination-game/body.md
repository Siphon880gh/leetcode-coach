Start with `1..n` sorted. Delete every other value left to right, then right to left, and keep alternating until one number remains. `n = 9` → `6` (`1 2 3 4 5 6 7 8 9` → `2 4 6 8` → `2 6` → `6`). `n = 1` → `1`. `n` is up to `1e9`.

## Track the remaining head, not the list

Building `arr` is impossible at `1e9`. After each pass the survivors form an arithmetic sequence: first value `head`, gap `step`, count `remaining`.

A left-to-right pass always removes `head`, so `head` moves forward by `step`. A right-to-left pass removes `head` only when `remaining` is odd (the leftmost is also an “every other” from the right). Then `remaining` becomes `remaining / 2` and `step` doubles. Stop when one value is left; that value is `head`.

Equivalently keep both ends `a1` and `an` (doocs): the end you scan from always moves by `step`; the other end moves only on an odd count.

Find the Winner of the Circular Game (1823) is Josephus in one direction with a fixed `k`. The closed form for “only left-to-right every other” does not apply here because the scan flips each round.

Do not simulate with a deque or linked list. Do not use the one-direction `2L + 1` Josephus formula. Do not forget that an odd-length right-to-left pass also moves `head`.

Time: O(log n)  
Space: O(1)

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

Find every value that appears more than ⌊n / 3⌋ times. `[3,2,3]` → `[3]`. `[1]` → `[1]`. `[1,2]` → `[1,2]`. n up to 5×10⁴. Follow-up: linear time, O(1) extra.

## Two votes, then prove the counts

Majority Element (169) asks for more than ⌊n / 2⌋ and **guarantees** a winner, so one candidate and no verify pass. Here the bar is n/3, so at most two answers. A hash of counts is O(n) extra. Returning the 169 candidate only misses the second value (`[1,2]`).

Keep `(m1, n1)` and `(m2, n2)`, start `m2` as a sentinel different from `m1`. For each `x`: if it equals `m1` increment `n1`; else if it equals `m2` increment `n2`; else if `n1` is 0 take `m1 = x`; else if `n2` is 0 take `m2 = x`; else decrement both counts (a third distinct value cancels one from each). After the sweep, **count** `m1` and `m2` in `nums` and keep those with count strictly greater than `n / 3` (integer divide). Skip a candidate equal to the other. Do not emit without the second pass: pairing can leave a leftover that never beat n/3.

**Time:** O(n)  
**Space:** O(1)

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

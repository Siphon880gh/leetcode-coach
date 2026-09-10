Integer `n` in a 32-bit signed range. True iff `n` equals 4 to a non-negative integer power. 16 → true. 5 → false. 1 → true (`4⁰`). Follow-up: no loop, no recursion.

## Power of two, then even bit index

`4ˣ` is `2` to an even power, so the binary form has exactly one `1`, and that `1` sits at an even index (LSB is index 0). Three checks, all O(1):

1. `n > 0` (zero and negatives are out).
2. `n AND (n − 1) == 0` — Power of Two (231): exactly one 1-bit.
3. `n AND 0xAAAAAAAA == 0` — `0xAAAAAAAA` has 1s on the odd indices. If the AND is 0, the lone 1 is on an even index.

8 (`1000`) fails (3). 2 fails (1). 4 (`100`) passes.

Do not only test 231 (that accepts 2, 8, 32). Do not loop `n = n / 4` (the follow-up forbids it). Do not treat this as Power of Three (326).

Time: O(1)  
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

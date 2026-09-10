Each envelope is `[w, h]`. You may nest A inside B only if `w` and `h` are both strictly larger. You may not rotate. Return the longest nest chain. `[[5,4],[6,4],[6,7],[2,3]]` → 3 (`[2,3]` then `[5,4]` then `[6,7]`). Three copies of `[1,1]` → 1. Up to 1e5 envelopes.

## Width up, height down, then LIS

Sort by increasing width. On equal width, put taller first. Then compute LIS on the height sequence with the usual patience-sort tails array: if `h` is larger than every tail, append; else replace the first tail that is ≥ `h`. The length of that array is the answer.

The reverse-height tie-break stops two envelopes of the same width from both joining the increasing-height chain. Do not run O(n²) “for each envelope, scan all smaller” — n is 1e5. Do not treat equal width or equal height as a valid nest. Do not rotate to swap the two sides.

Time: O(n log n)  
Space: O(n) for the tails

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

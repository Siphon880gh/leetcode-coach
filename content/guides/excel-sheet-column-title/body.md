Column number to Excel title. A=1 … Z=26, AA=27, AB=28. `1` → `A`. `28` → `AB`. `701` → `ZY`. `columnNumber` up to 2³¹−1.

## Subtract 1 so remainder 0 means Z

Excel is 1-based: there is no 0 digit. Skipping `n -= 1` maps 26 to a remainder 0 and an extra quotient 1, which is not Z. Title-to-number is the inverse problem. Two Sum II is pointers. 26 is Z, not AA. AA is 27.

Repeatedly: `n -= 1`, emit `A + n%26`, then `n //= 26`. Letters come out least-significant first, so reverse at the end.

Walk 28: 28−1=27, 27%26=1 → B, 27//26=1; then 1−1=0, 0%26=0 → A; reverse → AB. 701: after subtract-1, 700%26 is Y, then 26 becomes Z on the next subtract-1 → ZY. Column 1 is a single A.

**Time:** O(log n)  
**Space:** O(log n) for the letters

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

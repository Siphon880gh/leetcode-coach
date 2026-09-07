Column title to Excel number. A=1 … Z=26, AA=27, AB=28. `"A"` → 1. `"AB"` → 28. `"ZY"` → 701. Length 1 to 7, uppercase only. Inverse of Excel Sheet Column Title (subtract-1, then emit letters).

## Horner: times 26, then add this letter

Column Title walks remainders and reverses. Here you already have the most-significant letter first. Two Sum III is a stream pair map. Majority Element is a vote.

`ans = 0`. For each character `c`: `ans` becomes `ans` times 26 plus (`c` minus `A` plus 1). A is 1, not 0. There is no subtract-1 on this direction.

`"AB"`: start 0; A → 1; then 1 times 26 plus 2 → 28. `"ZY"`: Z is 26, then 26 times 26 plus 25 → 701. Do not treat this as 0-based base-26 (that would map A to 0).

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

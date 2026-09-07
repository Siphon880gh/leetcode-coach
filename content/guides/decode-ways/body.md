Count ways to map a digit string to A–Z (1..26). Length ≤ 100.

`12` → 2. `226` → 3. `06` → 0.

## One digit or two, skip 0

Climbing Stairs always adds `f[i-1] + f[i-2]`. Here a 0 cannot stand alone, and 27 is not a letter. Atoi reads one number. Unique Paths counts a grid. Integer to Roman emits one numeral.

`f[0] = 1` (one empty decode). For each `i`: if `s[i-1]` is not 0, take `f[i-1]`; if the two-digit slice is 10..26, add `f[i-2]`. A leading 0 leaves `f[1] = 0`. Return `f[n]` — 0 if impossible.

**Time:** O(n)  
**Space:** O(n)

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

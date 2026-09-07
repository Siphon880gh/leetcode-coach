How many trailing zeroes in n factorial. `3` → 0 (6 has none). `5` → 1 (120). `0` → 0. n up to 10⁴. Follow-up: logarithmic time — do not compute the factorial.

## Sum n//5 + n//25 + … until n is 0

Excel Column Number is base-26 Horner. Two Sum III is a stream map. Computing n factorial then counting zeros is too big and linear in the digits.

A trailing zero is a factor 10 = 2 times 5. In n factorial there are always more 2s than 5s, so the answer is the number of 5s in `[1, n]`. 25 contributes an extra 5, 125 another, and so on.

`ans = 0`. While `n`: `n //= 5`; `ans += n`. First divide counts multiples of 5; next counts multiples of 25; then 125. Example 130: 26 + 5 + 1. Five factorial is 120, one trailing zero. Three factorial is 6, zero trailing zeros.

**Time:** O(log n)  
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

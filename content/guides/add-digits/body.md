Given `num`, repeatedly add its digits until one digit remains, and return that digit. `38` → `2` (`3 + 8 = 11`, then `1 + 1 = 2`). `0` → `0`. `0 ≤ num ≤ 2³¹ − 1`. Follow-up: O(1), no loop or recursion.

## Digital root, not Happy Number’s squares

Happy Number (202) sums **squares** of digits and hunts for 1 vs a cycle. Plus One mutates a digit array. Here you sum the digits as-is until the result is `< 10`. A loop `while num ≥ 10: num = sum of digits` is correct and O(log num) per pass, but the follow-up forbids it.

A number is congruent to the sum of its digits modulo 9. The digital root is therefore `num mod 9`, except multiples of 9 map to `9` (not `0`) unless the number is `0`. Compact form: `0` if `num == 0`, else `(num − 1) % 9 + 1`. That sends `9, 18, 27, …` to `9` and `38` to `2`. Do not return `num % 9` for `9` (that is `0`). Do not square the digits.

**Time:** O(1)  
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

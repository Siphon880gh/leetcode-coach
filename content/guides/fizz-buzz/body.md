Integer `n` from 1 to 1e4. Return a 1-indexed string list of length `n`: `FizzBuzz` when `i` is divisible by both 3 and 5, `Fizz` when only by 3, `Buzz` when only by 5, otherwise the decimal of `i`. `n = 3` → `["1","2","Fizz"]`. `n = 5` → `["1","2","Fizz","4","Buzz"]`. `n = 15` ends with `FizzBuzz`.

## Walk 1..n; joint multiple first

For each `i`, test `i % 15 == 0` before the single-factor tests. If you test 3 first and return `Fizz`, 15 never becomes `FizzBuzz`. Concatenating `Fizz` then `Buzz` when each factor hits is the same joint case. The array is 1-indexed in the statement (`answer[i]` talks about value `i`), but you still append in order from 1.

Fizz Buzz Multithreaded (1195) prints the same strings from four threads with a lock; here there is one sequential walk.

Do not start the loop at 0. Do not emit `Fizz` for 15. Do not return integers instead of strings.

Time: O(n)  
Space: O(1) besides the answer list

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

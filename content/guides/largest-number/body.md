Non-negative integers `nums`. Arrange them to form the largest number, returned as a string (it can overflow a 64-bit int). `[10,2]` → `"210"`. `[3,30,34,5,9]` → `"9534330"`. Length 1 to 100; each value 0 to 1e9.

## Concatenation order, not numeric order

Rank Scores ranked floats with dense rank. Here the order of **pieces** is the whole problem.

Numeric descending is wrong: 10 then 2 is `"102"`, but `"210"` is larger. Compare two candidates as strings: put `a` before `b` when `a+b` is greater than `b+a`. `3` vs `30`: `"330"` beats `"303"`, so 3 first. `3` vs `34`: `"343"` beats `"334"`, so 34 first. That comparator is transitive enough for sort in this problem.

Python: stringify, `sort` with `cmp_to_key` so `a+b < b+a` means `a` goes later. Join. If the first string after sort is `"0"`, every piece was zero — return `"0"`, not `"000"`.

**Time:** O(n log n · L) with L the digit length of a concat  
**Space:** O(n L) for the strings

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

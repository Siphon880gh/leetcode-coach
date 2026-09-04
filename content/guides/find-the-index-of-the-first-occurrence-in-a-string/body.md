Return the first index where `needle` occurs in `haystack`, or `-1`. Lengths 1..10⁴, lowercase only. Empty needle is not in these constraints (both lengths at least 1).

`"sadbutsad"`, `"sad"` → 0 (also matches at 6). `"leetcode"`, `"leeto"` → `-1`.

## Window compare

Let `n`, `m` be the lengths. For `i` from `0` to `n - m`, if `haystack[i : i+m] == needle`, return `i`. Then return `-1`.

KMP (or Boyer–Moore) is O(n + m) and worth it when you need guaranteed linear time; brute windows are enough at 10⁴.

**Time:** O((n − m) × m) brute  
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

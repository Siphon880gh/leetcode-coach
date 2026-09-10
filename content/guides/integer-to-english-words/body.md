Non-negative `num` (0 through 2³¹ − 1). Return English words with spaces, no extra trailing space. `123` → `One Hundred Twenty Three`. `12345` → `Twelve Thousand Three Hundred Forty Five`. `1234567` → `One Million Two Hundred Thirty Four Thousand Five Hundred Sixty Seven`.

## Zero; then chunks of three digits

Integer to Roman maps place values to symbols. Here the unit is a **three-digit group** plus a scale word: Billion, Million, Thousand, or nothing for the last group.

If `num` is 0, return `Zero` (the helper would otherwise emit nothing). Walk `i = 10⁹`, then `i /= 1000` each step. When `num / i` is nonzero, convert that chunk of at most 999, append the scale, then `num %= i`. Skip a group that is 0 so you do not print a stray Million.

Helper `transfer(x)` for `x` in 0..999: 0 → empty; `x < 20` → ones/teens table; `x < 100` → tens table plus `transfer(x mod 10)`; else ones digit of hundreds, then `Hundred`, then `transfer(x mod 100)`. Spell **Forty** not Fourty. Join pieces and strip.

Do not emit `Zero` inside a larger number (`100` is `One Hundred`, not `One Hundred Zero`). Do not convert to Roman numerals. Do not drop the teens table and invent `Ten Three`.

**Time:** O(1) — at most four groups, each a constant-size helper  
**Space:** O(1) besides the output string

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

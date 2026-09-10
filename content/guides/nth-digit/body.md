Imagine writing every positive integer in order: `1, 2, …, 9, 10, 11, …`. Return the `n`th digit of that infinite string. `n` is at least `1` and at most `2³¹ − 1`. Examples: `n = 3` → `3`. `n = 11` → `0` because the stretch `1…9,10` uses ten digits for the singles plus the `1` of `10`, so the eleventh digit is the `0`.

## Subtract k-digit runs until n lands in one

There are `9 × 10^(k−1)` integers with exactly `k` digits, so that block contributes `k × 9 × 10^(k−1)` characters. Start at `k = 1`, `cnt = 9`. While `k × cnt` is still smaller than `n`, subtract that product from `n`, add `1` to `k`, and multiply `cnt` by `10`. Use a 64-bit type for the product: `k = 9` and `cnt = 9 × 10⁸` overflows a signed 32-bit int.

Once `n` sits in the `k`-digit block, the number is `10^(k−1) + (n − 1) / k` (integer divide) and the digit index inside that number is `(n − 1) mod k`. Read that character.

Building the string until length `n` is impossible at `2³¹ − 1`. Integer to English (273) spells words. Add Digits (258) folds a single integer, it does not walk the concatenated sequence.

Do not treat `n` as an index into `1..n` as numbers (the 11th number is 11, the 11th digit is 0). Do not forget to widen `k × cnt`. Do not use a 0-based digit index without the `(n − 1)` shift.

Time: O(log n)  
Space: O(1)

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

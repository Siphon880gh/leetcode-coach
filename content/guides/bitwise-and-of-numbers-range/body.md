Inclusive range `[left, right]`. Return the bitwise AND of every integer in that range. `0 ≤ left ≤ right ≤ 2³¹ − 1`. `5..7` → `4`. `0..0` → `0`. `1..2147483647` → `0`.

## Clear the lowest 1 of right until it no longer exceeds left

Number of 1 Bits used `n AND (n − 1)` to drop one set bit per loop. Reverse Bits moved bits; Single Number XOR-folded pairs. Here you AND a whole interval — you cannot walk every integer when the span can be two billion.

A bit that is 1 in the answer must be 1 in **every** number from `left` through `right`. If `left` and `right` differ, some bit flipped in the range, so that bit (and every bit below it) is 0 in the AND. The surviving bits are the **common prefix**.

While `left < right`, set `right = right AND (right − 1)`. That clears the lowest 1 of `right`. Each clear removes a bit that cannot survive the range. Stop when `right ≤ left`; return `right`. Sample: `7` (111) → `6` (110) → `4` (100). `4` is no longer greater than `5`, so the AND is `4`.

Do not loop `ans = left` then `ans AND i` for every `i`. The large sample would time out and the answer is already `0` the moment the range covers both even and odd around a power of two. Shifting both sides right until they are equal, then shifting back, is the same common-prefix idea; Kernighan on `right` is shorter.

**Time:** O(1) (at most 32 clears)  
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

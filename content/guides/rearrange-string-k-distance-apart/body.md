String `s` (lowercase) and integer `k`. Rearrange so any two equal letters are at least `k` positions apart. If that is impossible, return empty. `aabbcc` with `k = 3` → `abcabc`. `aaabc` with `k = 3` → empty. Length up to 3×10^5. `k = 0` means no gap rule.

## Place the current most-frequent leftover; wait k before reuse

Count letters. Put `(remaining, letter)` in a max-heap. Repeatedly pop the top, append that letter, and push `(remaining−1, letter)` into a cooldown queue. When the queue length is at least `k`, pop the front; if leftover count is still positive, push it back onto the heap.

If the heap goes empty while the answer is shorter than `s`, leftover copies are stuck in cooldown too close together → return `""`. Reorganize String (767) is this problem with `k = 2`. Do not backtrack over 3×10^5 characters. Do not sort once and then round-robin without a cooldown (a later burst of one letter can still violate `k`).

Time: O(n log 26)  
Space: O(26)

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

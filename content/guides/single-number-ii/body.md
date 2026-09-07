Every value appears three times except one that appears once. Return that one. Linear time, O(1) extra space.

`[2,2,3,2]` → `3`. `[0,1,0,1,0,1,99]` → `99`.

## Bits of triples are multiples of 3

XOR-ing the whole array like Single Number I fails: `x XOR x XOR x` is `x`, so triples do not cancel. A frequency map or a set of uniques is extra O(n). Gray code’s `i XOR (i>>1)` is a different sequence. Candy’s two slopes are neighbor ratings, not bits. `(3 × unique-sum − total) / 2` still needs a set.

For each bit `i` from 0 to 31, `cnt` is the sum of `(num >> i) & 1` over `nums`. If `cnt % 3 ≠ 0`, set that bit on `ans` (`ans |= 1 << i`). In Python, bit 31 is the sign: subtract `1 << 31` instead of OR-ing a huge unsigned value.

`% 3` works because each triple adds 0 or 3 to a bit’s count; the remainder is only the singleton’s 0 or 1. `% 2` is XOR and cannot tell three 1s from one 1.

Return `ans` after OR-ing every bit whose count is not divisible by 3 — the reconstructed integer, not the first nonzero remainder or a bit index.

**Time:** O(n) (32 passes)  
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

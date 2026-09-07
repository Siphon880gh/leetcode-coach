Reverse the 32 bits of a signed integer `n` and return that integer. `n` is even, from 0 through 2³¹ − 2. `43261596` → `964176192`. `2147483644` → `1073741822`.

## 32 peels: low bit of n into bit 31−i

Single Number XOR-folds values; Gray code maps `i` to `i XOR (i >> 1)`; Number of 1 Bits will count set bits. None of those reverse bit order.

`ans` starts at 0. For `i` from 0 through 31: take the current low bit with `n & 1`, shift it left by `31 − i`, OR it into `ans`, then `n >>= 1`. Bit 0 of the original lands at bit 31; bit 1 lands at 30; bit 31 lands at 0. You must run all 32 steps even after `n` becomes 0 — leftover high zeros of `n` are the trailing zeros of the reverse. Early-exit is only safe because those remaining bits of `ans` are already 0.

Do not reverse the decimal digits. Do not stop at the last 1: leading zeros of a 32-bit word still occupy slots. If this runs often, cache a 256-entry table of reversed bytes and assemble four lookups; one call is just the 32-step loop.

**Time:** O(1) (32 steps)  
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

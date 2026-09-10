Integers `a` and `b` in `−1000 .. 1000`. Return `a + b` without using `+` or `−`. `1, 2` → `3`. `2, 3` → `5`.

## XOR is the bits; AND-shift is the carry

XOR (`a xor b`) is addition if no two 1s sit in the same bit. Where both bits are 1, that is a carry into the next column: `(a AND b) shifted left 1`. Set `a` to the XOR, `b` to the carry, and loop until the carry is 0. Then `a` is the sum.

Java and C++ 32-bit ints wrap the same way two’s complement addition does, including negatives. Python ints are unbounded: mask both values to 32 bits each step (`AND 0xFFFFFFFF`), then if the sign bit is set, convert back to a negative Python int (`~(a xor 0xFFFFFFFF)`).

Do not call `+` even in a helper. Add Two Numbers (2) walks reversed digit lists. Add Binary (67) is the same carry idea on bit strings, not machine words. A language `sum()` still uses plus.

Time: O(1) for a fixed 32-bit word (at most 32 carry rounds)
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

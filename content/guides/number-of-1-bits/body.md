Count the set bits of a positive integer `n` (Hamming weight). `1 ≤ n ≤ 2³¹ − 1`. `11` → `3` (binary 1011). `128` → `1`. `2147483645` → `30`.

## Clear the lowest 1, once per loop

Reverse Bits rearranges all 32 slots; Single Number XOR-folds an array; Gray code maps `i` to `i XOR (i >> 1)`. Here you only need how many 1s exist.

`n & (n - 1)` turns off the lowest set bit and leaves the rest. Start `ans` at 0. While `n` is nonzero: `n &= n - 1`, then `ans += 1`. When `n` is 0 you are done. `11` (1011) → 1010 → 1000 → 0, three ticks. Shifting and testing `n & 1` thirty-two times also works; Kernighan stops after the last 1, so the loop length is the answer, not the word width.

Do not count decimal digits. Do not return the integer value of the last 1. If this runs often, cache 256 eight-bit popcounts and add four lookups.

**Time:** O(k) for k set bits (at most 32)  
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

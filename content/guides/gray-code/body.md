n-bit Gray sequence of 2^n integers in `[0, 2^n − 1]`, start at 0, each value once, adjacent (and first/last) differ by exactly one bit. 1 ≤ n ≤ 16.

`n = 2` → `[0,1,3,2]`. `n = 1` → `[0,1]`.

## i XOR (i shifted right)

`0,1,2,3` is `00,01,10,11` — 1 to 2 flips two bits. Permutations generates all orders. Subsets records collections of numbers. Bit reversal is a different permutation. Hamming Distance returns a count.

Binary-reflected Gray code: `ans[i] = i ^ (i >> 1)` for `i` from 0 to `(1 << n) - 1`. Each Gray bit is binary[i] XOR binary[i+1]. Return the list, not a single integer. Any valid sequence is accepted; this formula is one of them.

**Time:** O(2^n)  
**Space:** O(1) besides the answer

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

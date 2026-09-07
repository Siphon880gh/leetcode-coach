Add two binary strings and return a binary string. Lengths up to 10⁴. No leading zeros except `"0"`.

`"11"` + `"1"` → `"100"`. `"1010"` + `"1011"` → `"10101"`.

## Carry from the last bit

Two pointers at the last characters, plus a `carry`. While either index is still in range **or** `carry` is nonzero: add the two bits (0 if a pointer is past the start) into `carry`, append `carry % 2`, then set `carry` to `carry // 2`. Reverse the collected bits.

The leftover-carry clause is why `"11"` + `"1"` is `"100"`, not `"00"`. 10⁴ bits do not fit in 64-bit or 128-bit integers — never parse `a` and `b` as machine ints. Plus One adds 1 to a decimal digit array (mod 10); here you add two bit strings (mod 2).

**Time:** O(max(m, n))  
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

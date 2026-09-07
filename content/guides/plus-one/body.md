`digits` is a large integer, most-significant first, no leading zeros. Add one and return the digit array. Length ≤ 100.

`[1,2,3]` → `[1,2,4]`. `[4,3,2,1]` → `[4,3,2,2]`. `[9]` → `[1,0]`.

## Carry from the last digit

Walk right to left. At each index: add 1, then take the result modulo 10. If that digit is not 0, the carry died and every digit to the left stays the same — return. If the loop finishes, every digit rolled to 0 (the number was all 9s): prepend 1 (`[9,9]` → `[1,0,0]`).

A 100-digit value does not fit in 32-bit, 64-bit, or 128-bit integers — never join the array into a machine int. Add Two Numbers walks two reversed linked lists; here you return a digit array and grow it only on all-nines.

**Time:** O(n)  
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

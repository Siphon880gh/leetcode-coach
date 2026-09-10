A 32-bit integer `num`. Return its lowercase hex string. Negatives use two’s complement (no minus sign). No leading zeros except the number 0 itself. You may not call a built-in that prints hex. `26` → `1a`. `-1` → `ffffffff`.

## Eight nibbles from high to low

If `num` is 0, return `0`. Otherwise walk `i` from 7 down to 0. Each nibble is the 4 bits starting at bit `4i`: shift `num` right by `4i`, then mask with `0xF`. Map 0–15 through `0123456789abcdef`. Skip a nibble while the answer is still empty and the nibble is 0; after the first nonzero digit, keep every later nibble (including zeros).

Python ints are unbounded, but eight nibbles is exactly 32 bits, so `-1` still fills `ffffffff`. An unsigned-shift loop that peels the low nibble and reverses is the same 32-bit view.

Integer to English Words (273) speaks base 10 in words. Base 7 (504) converts to a different radix with a sign. Reverse Integer (7) is decimal digits, not hex.

Do not return `-1` as `"-1"`. Do not call `hex()` or `format`. Do not keep a leading `0` on `26`. Do not emit more than eight hex digits.

Time: O(1) eight nibbles  
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

Integer array `data` (length up to `2e4`, each value `0..255`). Only the low 8 bits are the byte. Return true iff the bytes are a valid UTF-8 sequence of 1-to-4-byte characters.

Patterns: `0xxxxxxx` (1 byte); `110xxxxx 10xxxxxx` (2); `1110xxxx` plus two `10xxxxxx`; `11110xxx` plus three `10xxxxxx`. `[197,130,1]` → true (`11000101 10000010 00000001`). `[235,140,4]` → false (a 3-byte lead, one good continuation, then `00000100` is not `10xxxxxx`).

## Remaining continuation count

`cnt` is how many `10xxxxxx` bytes are still owed, starting at 0. For each byte `v`:

- If `cnt > 0`: it must satisfy `v >> 6 == 0b10`; then decrement `cnt`. Else false.
- Else it is a new lead: `v >> 7 == 0` → 1-byte (`cnt = 0`); `v >> 5 == 0b110` → need 1; `v >> 4 == 0b1110` → need 2; `v >> 3 == 0b11110` → need 3. Any other prefix (a bare `10xxxxxx` lead, or 5-byte `111110…`) is false.

After the last byte, `cnt` must be 0 (an unfinished character is invalid).

Decode String (394) is nested `k[encoded]` brackets, not UTF-8. This problem does not check Unicode overlong encodings beyond the bit templates above.

Do not accept 5-byte leads. Do not treat a continuation byte as a new character while `cnt > 0`. Do not return true if `cnt` is still positive at the end.

Time: O(n)  
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

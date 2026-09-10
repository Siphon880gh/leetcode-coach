Design `encode(strs)` → one string and `decode(s)` → the original list. Strings may be empty and may hold any of 256 ASCII bytes. Length at most 200 strings, each length at most 200. `["Hello","World"]` round-trips. `[""]` round-trips to one empty string. No `eval`.

## Length, then payload; never a naive join

Serialize Binary Tree prefixes node counts or uses sentinels. Here there is no tree, only a list. Joining with commas (or `#`) fails the moment a string contains that character.

For each `s`, write a **fixed-width** decimal length (four characters is enough: max length 200) then write `s` itself. Decode: while the cursor is inside `s`, read four characters as `size`, then take the next `size` characters as one string, then advance. Empty list elements become length `0` plus no payload. Equivalent: `str(len(s)) + "#" + s` if you parse digits until `#` — the `#` is a terminator for the **length**, not for the payload, so a `#` inside `s` is fine.

Do not `",".join`. Do not `eval` a Python list. Do not assume strings lack spaces.

**Time:** O(total characters)  
**Space:** O(total characters) for the encoded string and the answer

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

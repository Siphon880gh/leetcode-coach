`t` is a shuffle of `s` plus one extra lowercase letter (`t.length == s.length + 1`, `s` may be empty). Return the added letter. `"abcd"` / `"abcde"` → `e`. `""` / `"y"` → `y`. Lengths up to 1000.

## Count, XOR, or sum of code points

Count letters in `s`. Walk `t` and decrement; when a count goes negative, that character is extra. XOR of every character in `s` and `t` leaves the extra bit pattern. Sum of `ord` values: `chr(sum(t) − sum(s))`.

Sorting both and scanning for the first mismatch also works but is slower. First Unique Character (387) looks for a letter that appears once in one string. Single Number (136) XORs integers, not an extra shuffled letter.

Do not return a letter that already existed in `s` just because it moved. Do not assume the extra is at the end of `t`. Do not skip the empty-`s` case.

Time: O(n)  
Space: O(26) counting, or O(1) XOR / sum

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

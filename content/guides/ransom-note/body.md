`ransomNote` and `magazine` are lowercase, lengths up to 1e5. Return true iff you can build the note using letters from the magazine, each magazine letter at most once. `a` / `b` → false. `aa` / `ab` → false. `aa` / `aab` → true.

## Count magazine, spend on the note

Count every character in `magazine` (a 26-slot array or `Counter`). Walk `ransomNote` and decrement. If a count drops below 0, magazine does not have enough of that letter — return false. If the walk finishes, return true.

You can count the note first and check each letter’s need against magazine, same idea. Sorting both and two-pointer matching also works but is slower (`n log n`).

Valid Anagram (242) needs equal counts both ways. Ransom Note is a cover: magazine may have leftover letters. Group Anagrams (49) clusters many strings; here there are only two.

Do not reuse a magazine letter. Do not require `magazine` and `ransomNote` to be the same length. Do not scan magazine from scratch for every note letter (`O(m n)` at 1e5).

Time: O(m + n)  
Space: O(26)

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

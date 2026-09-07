After lowercasing and dropping non-alphanumeric characters, does `s` read the same both ways? Length up to 2e5; printable ASCII.

`"A man, a plan, a canal: Panama"` → true. `"race a car"` → false. `" "` → true.

## Skip junk, then compare lowercase

Palindrome Number reverses digits of an int. Reversing the raw string makes the Panama sample fail because of spaces, commas, and `A` vs `a`. Valid Palindrome II lets you delete one character. Max Path Sum is a tree. This is a boolean on one string with skips.

`i, j = 0, n-1`. While `i < j`: if `s[i]` is not alphanumeric, `i += 1`; else if `s[j]` is not, `j -= 1`; else if `lower` differs, return false; else step both. Skip each side independently (`if` / `elif`), then compare.

A string of only spaces is true: after skips, `i >= j`, and an empty alphanumeric string is a palindrome. Path Sum’s empty-tree false does not apply.

Return the boolean — true, false, true on the three samples — not the cleaned phrase `amanaplanacanalpanama`.

**Time:** O(n)  
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

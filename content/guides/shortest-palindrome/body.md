Given `s` (lowercase, length 0 to `5×10⁴`), add as few characters as possible **in front** so the result is a palindrome. `"aacecaaa"` → `"aaacecaaa"`. `"abcd"` → `"dcbabcd"`. Empty or already a palindrome → `s`.

## Longest palindromic prefix; prepend the rest reversed

Valid Palindrome only checks. Longest Palindromic Substring finds any center. Here the palindrome must **start at index 0** after you pad the left, so you keep the longest prefix of `s` that is already a palindrome and copy the leftover suffix reversed onto the front.

Walk `i` from 0. Maintain a forward hash of `s[0 .. i]` and a reverse hash of the same slice (multiply the new letter by `base^i` into the reverse). When the two hashes match, treat `s[0 .. i]` as a palindrome prefix and store `idx = i + 1`. Answer: reverse of `s[idx :]` plus `s`. Base 131, mod `10⁹ + 7` (or unsigned overflow). One pass, O(n).

Do not insert in the middle or at the end. Do not brute-check every prefix with two pointers — O(n²) dies at `5×10⁴`. KMP twin: build `s + "#" + reverse(s)` and read the last prefix-table value as the palindromic-prefix length.

**Time:** O(n)  
**Space:** O(n) for the answer (O(1) extra besides that)

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

Reverse the order of words in `s`. Collapse extra spaces; no leading or trailing space. `the sky is blue` → `blue is sky the`. A padded `hello world` → `world hello`. At least one word.

## Collect tokens, reverse the list

Reversing every character would scramble letters inside each word. Length of Last Word only returns a length. RPN and Simplify Path are different stacks. The output uses exactly one space between words and none at the ends. `a good` then three spaces then `example` becomes `example good a`.

Two pointers: `i` skips spaces; `j` runs to the next space; append `s[i:j]`; `i = j`. Then join the reversed word list with a single space. Python `split()` with no args does the same skip-and-split. Word order flips; letters inside a word stay. Padding is stripped.

Follow-up in-place: reverse the whole buffer, then reverse each word, squeezing spaces as you copy. The result is never empty.

**Time:** O(n)  
**Space:** O(n) for the word list

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

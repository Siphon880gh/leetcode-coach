Pack `words` into lines of exactly `maxWidth`. Greedy: as many words as fit. Each line is a string of that width. At least one word; no word is longer than `maxWidth`.

`["This","is","an","example","of","text","justification."]`, width 16 → `"This    is    an"`, `"example  of text"`, `"justification.  "`.

## Last line left, others even gaps

Take the next word, then keep adding `1 + next length` while that still fits. Then format:

- Last line (`i` reached n) or a single word: join with one space, pad spaces after the last word. `"acknowledgment"` has zero gaps — do not divide by `len(t) - 1`.
- Other lines with k words (k-1 gaps): leftover extras go to the **left** slots. Gap j gets base width plus one when `j < remainder`.

Fully justifying the last line would put extra spaces between `"shall"` and `"be"`. Length of Last Word only counts a token; this problem returns the list of lines.

**Time:** O(L) where L is the total character count  
**Space:** O(L)

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

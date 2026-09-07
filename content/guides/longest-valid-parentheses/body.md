`s` is only `(` and `)`. Return the length of the longest well-formed contiguous substring. Empty string is 0. n ≤ 3×10⁴.

`"(()"` → 2 (`"()"`). `")()())"` → 4 (`"()()"`).

## Stack of indices

Valid-parentheses only asks “is the whole string balanced.” Here you need the **longest** balanced run, so leftover junk on either side is allowed.

Keep a stack of **indices**, not characters. Seed it with `-1` as a base (the last index that is not part of a valid run).

Walk left to right:

- `(` → push `i`.
- `)` → pop. If the stack is now empty, this closer has no opener: push `i` as the new base. Else the run that just closed ends at `i` and starts after `stack[-1]`. Length is `i - stack[-1]`. Track the max.

`"()()"`: after the last closer the stack still holds `-1`, so length is `3 - (-1)` = 4. `"(()"`: leftover opener stays on the stack, so the inner pair is `2 - 0` = 2.

DP that stores the longest valid suffix ending at each `)` is also O(n), but the index stack is the same idea as matching parens and uses O(n) space either way.

**Time:** O(n)  
**Space:** O(n)

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

`s` is only `()[]{}`. Valid means every closer matches the most recent unmatched opener, same type, and nothing is left over.

`"()"` and `"()[]{}"` and `"([])"` are true. `"(]"` and `"([)]"` are false. Length up to 10⁴.

## Stack

Walk left to right:

- Opener → push it.
- Closer → if the stack is empty, false. Else pop. The popped opener plus this closer must be one of `()`, `[]`, `{}`.

When the scan ends, the stack must be empty (no leftover openers).

You can instead push the expected closer when you see an opener; then a closer just has to equal `pop()`. Same idea.

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

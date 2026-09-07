Unix absolute path to canonical form. Always starts with `/`. Length ≤ 3000.

`"/home/"` → `"/home"`. `"/home//foo/"` → `"/home/foo"`. `"/../"` → `"/"`. `"/.../a/../b/c/../d/./"` → `"/.../b/d"`.

## Stack names, skip `.` and empty

Split on `/`. Empty tokens are extra slashes — drop them. A lone `.` is the current directory — drop it. A `..` pops the last name if the stack is nonempty; at root it is a no-op so `"/../"` stays `"/"`. Any other token is a real name, including `...`.

Join the stack with one `/` and prefix a leading `/`. Root is just `"/"`. Regex that only collapses slashes leaves `..` in place. Valid Parentheses matches brackets; this returns a path string.

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

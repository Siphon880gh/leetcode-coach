`input` (length up to 1e4) is a valid file tree: lines split by newline, depth by leading tabs. Return the length of the longest absolute file path (`dir/a/b.ext`), or 0 if there is no file. `"dir\n\tsubdir1\n\tsubdir2\n\t\tfile.ext"` → 20. The longer sample → 32. `"a"` is a directory, so 0.

## Stack of prefix lengths

Walk each line. `ident` = number of leading tabs (depth). Pop the stack while it is deeper than `ident`, so the top is the parent directory. Count the name length; a `.` in the name means a file.

If a parent exists, add `parent_len + 1` (the `/`). Files update the answer with that total. Directories push the total onto the stack (they become prefixes for children). Do not add files to the stack.

A file is `name.extension`; directory names have no dot. The path has no trailing slash. Simplify Path (71) normalizes `.` / `..` tokens; here tabs already encode the tree.

Do not treat `"a"` as a file. Do not forget the `/` between components. Do not split on spaces instead of newline/tab. Do not keep a sibling directory on the stack after a same-depth neighbor (pop first).

Time: O(n)  
Space: O(depth)

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

Comma-separated preorder: integers or `'#'` for null. Return whether the string is a valid binary-tree serialization. You may not rebuild the tree. `"9,3,4,#,#,1,#,#,2,#,6,#,#"` → true. `"1,#"` → false (a node needs two children in this encoding). `"9,#,#,1"` → false (tokens after the tree is already complete). Length up to 1e4. Format is already well-formed (no empty slots between commas).

## Collapse `value, #, #` into one `#`

A leaf is a value followed by two nulls. Those three tokens are themselves a finished subtree, so they behave like a null to the parent. Split on commas, push each token, and while the top three are (non-`#`, `#`, `#`), pop them and push `#`. At the end the whole tree must have collapsed to a single `#`.

Slot count is the same idea without an explicit stack of strings: start with 1 vacancy for the root. A `'#'` spends one vacancy. A number spends one vacancy and adds two. Vacancy must stay non-negative, and finish at 0 with every token consumed.

Do not allocate TreeNode objects. Do not accept leftover tokens after vacancy hits 0. Do not treat `"#"` as invalid (empty tree is one null).

Time: O(n)  
Space: O(n) stack, or O(1) slot counter besides the split

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

String `s`, length 0 to 300. Only space is `' '`. Letters, digits, and punctuation can sit inside a segment. Return how many contiguous non-space runs there are.

`"Hello, my name is John"` → 5: `Hello,` / `my` / `name` / `is` / `John`. `"Hello"` → 1.

## Count a start, not every letter

Walk index `i`. If `s[i]` is not a space and (`i` is 0 or `s[i-1]` is a space), this is the first character of a new segment — add 1. Extra spaces between words do not add extra counts. Leading or trailing spaces do not. An empty string or all spaces is 0.

`split` on spaces then drop empty pieces is the same count, at extra space. Length of Last Word (58) wants the length of the last run, not how many runs exist. Reverse Words in a String (151) rewrites the words; here you only count.

Do not treat punctuation as a separator (the comma in `Hello,` stays on that word). Do not count every non-space character. Do not use other whitespace (tabs) — the problem only has `' '`.

Time: O(n)  
Space: O(1)

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

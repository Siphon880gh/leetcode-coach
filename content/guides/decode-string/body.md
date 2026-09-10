Encoded `s` (length up to 30): letters, digits, and well-formed `[]`. `k[chunk]` repeats `chunk` exactly `k` times (`k` in `1..300`). Digits appear only as those counts. Output length stays within `1e5`. `"3[a]2[bc]"` → `"aaabcbc"`. `"3[a2[c]]"` → `"accaccacc"`. `"2[abc]3[cd]ef"` → `"abcabccdcdcdef"`.

## Count stack and prefix stack

Keep a running `num` and a current string `res`. Walk left to right:

- Digit: fold into `num` (ten times the old value plus this digit — `k` can be more than 9).
- `[`: push `num` on a count stack and `res` on a string stack; reset both so the inside starts empty.
- Letter: append to `res`.
- `]`: pop `k` and the saved prefix; `res` becomes prefix plus the current inner string repeated `k` times.

Nesting works because each `[` freezes the outer prefix. Recursion that decodes one bracket pair is the same idea.

UTF-8 Validation (393) is byte prefixes, not `k[chunk]`. Basic Calculator II (227) evaluates `+ − × /`, not repeats. Do not treat `3a` as valid input.

Do not parse `k` as a single digit when it is `12[a]`. Do not multiply strings with a raw star in a language that lacks repeat. Do not forget to reset `num` after `[`.

Time: O(output length)  
Space: O(n) stacks

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

`s` is a valid NestedInteger serialization (length up to about 5×10^4): digits, `-`, commas, and `[]`. Return a `NestedInteger` — either one integer or a list of NestedIntegers. `"324"` → integer 324. `"[123,[456,[789]]]"` → a list holding 123 and a nested list. Empty list is `"[]"`.

## Recurse on top-level slices, or a stack

If `s` does not start with `[`, it is a (possibly negative) integer: `NestedInteger(int(s))`. `"[]"` is an empty NestedInteger list.

Otherwise walk from index 1 with a `depth` of how many extra `[` are open. When `depth` is 0 and you see a comma or the last character, the slice `[j, i)` is one child — deserialize it recursively and `add` it. `[` / `]` bump depth so commas inside nested lists do not split the parent.

Stack twin: push a new list on `[`. Accumulate digits into `x` (if you saw `-`, negate when you flush). On `,` or `]` flush a finished number into `stk[-1]`. On `]` with more than one frame, pop that list and add it to the parent.

Nested List Weight Sum (339) and II (364) already have a NestedInteger tree; this problem builds that tree from text. `eval` / `json.loads` is not the intended parser (and nested lists are not JSON objects).

Do not `split(',')` without tracking brackets — `[123,[456]]` has a comma inside the inner list. Do not drop the minus on `-12`. Do not treat `"[]"` as the integer 0.

Time: O(n)  
Space: O(n) for recursion or the stack

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

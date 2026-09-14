Password length 1 to 50: letters, digits, `.`, `!`. Strong means length 6 to 20, at least one lowercase, one uppercase, and one digit, and no three identical characters in a row. One step is insert, delete, or replace a single character. Return the fewest steps. `"a"` → 5. `"aA1"` → 3. `"1337C0d3"` → 0.

## Three length regimes; deletes beat replacements on long runs

Let `types` be how many of {lower, upper, digit} already appear (0 to 3). A run of length `L` needs `floor(L/3)` replacements if you only replace.

If `n < 6`, inserts cover length and can also introduce missing types: answer `max(6 − n, 3 − types)`.

If `6 <= n <= 20`, you never need to delete for length. Replacements that break runs also fill missing types: answer `max(replace, 3 − types)`.

If `n > 20`, you must delete `n − 20` characters (those deletes are mandatory). Prefer deletes that also cut a replace: one delete from a run with `L % 3 == 0` saves one replace; two deletes from `L % 3 == 1`; then groups of three deletes from leftover replace budget. After spending deletes, answer is `(n − 20) + max(remaining replace, 3 − types)`.

Strong Password Checker II (2299) only tests whether a string already qualifies. Do not treat this as “insert until 6 and stop.”

Do not replace every third letter without using extra deletes when `n > 20`. Do not count `.` or `!` as a required character class. Do not allow a run of three after you finish.

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

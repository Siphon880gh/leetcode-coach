String `s` of lowercase letters and `(` / `)`. Delete the **fewest** parentheses so the rest is valid. Return **all unique** valid strings (any order). `"()())()"` → `"(())()"`, `"()()()"`. `")("` → `""`. Length up to 25; at most 20 parentheses.

## Count the extras, then skip or keep

Valid Parentheses (20) only asks whether one string is already valid. Generate Parentheses (22) builds from empty with a pair budget. Here you start from a dirty string and must not delete more than necessary.

One left-to-right scan: unmatched `)` increments `r` (those must go). Leftover `(` at the end is `l` (those must go). That pair `(l, r)` is the exact delete budget — any valid answer has length `n − l − r`.

DFS index `i` with remaining deletes `l`, `r`, and prefix open/close counts `lcnt`, `rcnt`, plus the built string `t`. Prune if leftover characters cannot cover `l + r`, or if `lcnt < rcnt` (prefix already invalid). At a `(` with `l > 0`, you may skip it. At a `)` with `r > 0`, you may skip it. Always try **keep** (letters always take this branch). When `i` hits `n` and both budgets are 0, add `t` to a set.

Do not BFS every one-deletion neighbor unless you want the slower “first valid layer” version. Do not drop letters. Do not return only one string if several minima exist.

**Time:** exponential in the parenthesis count, with prune (n ≤ 25)  
**Space:** recursion depth O(n) plus the answer set

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

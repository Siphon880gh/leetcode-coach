Party of `n` people `0 .. n−1`. At most one celebrity: everyone else knows them, they know nobody. You only call `knows(a, b)` (the `n × n` matrix is not yours). Return the label, or `−1`. Sample `[[1,1,0],[0,1,0],[1,1,1]]` → `1`. Cycle with no sink → `−1`. `2 ≤ n ≤ 100`. Follow-up: at most about `3 n` API calls.

## One candidate, then a full check

If `knows(a, b)` is true, `a` is not a celebrity. If it is false, `b` is not a celebrity (someone does not know `b`). So each call **kills** one person. Start `ans = 0`. For `i` from 1 to `n − 1`: if `knows(ans, i)`, set `ans = i`. After this pass exactly one person can still be the celebrity.

That person might still know someone, or someone might not know them. Second loop: for every `i ≠ ans`, if `knows(ans, i)` or not `knows(i, ans)`, return `−1`. Else return `ans`.

Do not query every pair (n²). Do not return the first-pass `ans` without verification. Do not treat `graph[i][i] == 1` as “knows self” in the celebrity definition — skip `i == ans` in the check.

**Time:** O(n) `knows` calls (about `3 n`)  
**Space:** O(1)

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

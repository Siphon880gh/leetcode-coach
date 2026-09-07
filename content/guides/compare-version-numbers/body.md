Compare two dotted version strings. Each revision is an integer (leading zeros ignored). Missing revisions are 0. Return −1, 1, or 0. `1.2` vs `1.10` → −1. `1.01` vs `1.001` → 0. `1.0` vs `1.0.0.0` → 0. Lengths up to 500.

## Parse revisions as integers; pad the short side with 0

Lexicographic string order would treat 10 as coming before 2. `float("1.10")` equals 1.1 and drops later revisions. Maximum Gap is array buckets. Token length is not the value: `01` and `001` are both 1.

Walk both strings; accumulate `a` and `b` until a dot (or 0 if that string is done). Build each revision as “times ten plus this digit,” not as a digit string. If `a != b` return −1 or 1. Skip the dots. If the loops finish, 0.

`1.2` vs `1.10`: second revisions 2 vs 10 as integers; 2 is less than 10, so −1. The character `1` in `10` is not a string-order win. `1.0` vs `1.0.0.0` keeps comparing 0 against missing 0.

**Time:** O(m + n)  
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

Given digit strings `low` and `high` (`low ≤ high`, length 1..15, no leading zeros except `"0"`), return how many strobogrammatic numbers lie in the closed range `[low, high]`. `"50"`..`"100"` → 3 (`69`, `88`, `96`). `"0"`..`"0"` → 1.

## Generate by length, then test the endpoints

246 **checks** one string. 247 **lists** every n-length rotate number. Here you **count** how many of those lists sit between two bounds.

Reuse `dfs(n)` from II: wrap `11`, `88`, `69`, `96` around a shorter core; wrap `00` only when the current length is not the finished `n` (no leading zero). Let `a = len(low)`, `b = len(high)`. For each length `n` from `a` through `b`, generate `dfs(n)` and increment when `int(s)` is between `int(low)` and `int(high)` inclusive. Lengths strictly between `a` and `b` are always in range (no leading zeros). Only the shortest and longest batches need the numeric (or same-length string) compare.

Do not walk every integer from `low` to `high` and run 246 (the span can be 15 digits). Do not return the list (that is 247). Do not skip `"0"` when it is a legal endpoint.

**Time:** exponential in the max length (output of the generators)  
**Space:** O(n) recursion plus one length’s list

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

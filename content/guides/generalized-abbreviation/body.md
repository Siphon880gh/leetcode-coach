Lowercase `word`, length 1..15. Return every **generalized abbreviation**: replace any set of non-overlapping, **non-adjacent** substrings with their lengths. `"word"` has 16 strings including `"4"`, `"3d"`, `"2r1"`, `"word"`. `"a"` → `["1","a"]`. Adjacent replacements like `"23"` from `"abcde"` are illegal — they would merge into `"5"`.

## One bit per character; flush the count on a keep

`n` is at most 15, so walk every mask in `0 .. 2^n − 1`. Bit `1` means this index is abbreviated (add to a run). Bit `0` means keep the letter: if the run is positive, append the decimal count, then append the letter, then reset the run. After the last index, flush a leftover run.

That automatically forbids two numbers next to each other: a number is written only when a kept letter (or the end) closes the run. DFS is the same choice: keep `word[i]`, or skip a block `word[i..j)` and then **must** keep `word[j]` (or finish). Unique Word Abbreviation (288) asks whether one abbreviation is unique in a dictionary — a different problem.

Do not emit `"23"`. Do not overlap two replaced ranges. Order of the list does not matter.

**Time:** O(n × 2^n)  
**Space:** O(n) for the builder (output size is Θ(2^n))

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

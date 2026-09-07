DNA string `s` over `A`, `C`, `G`, `T`. Return every length-10 substring that appears more than once, any order. `"AAAAACCCCCAAAAACCCCCCAAAAAGGGTTT"` → `"AAAAACCCCC"` and `"CCCCCAAAAA"`. `"AAAAAAAAAAAAA"` (13 As) → `"AAAAAAAAAA"` once. Length 1 to 1e5. Shorter than 10 → empty list.

## Count the window, emit only the second time

Reverse Words II reversed a char array. Here the unit is a **fixed 10-letter** slice.

For each start `i` from 0 through `n - 10`, take `t = s[i : i+10]`. Increment a map count for `t`. If that count **equals 2**, append `t` to the answer. Count 1 is the first sighting; 3 or more must not add again.

Rolling-hash twin: map A,C,G,T to 0..3. A 10-letter window is a base-4 integer. Slide by dropping the leftmost letter (subtract its contribution times 4^9) and appending the new letter (times 4 plus its code). Count hashes instead of strings; collisions are not an issue with 20 bits. Same “emit at 2” rule.

**Time:** O(n) windows (string keys cost 10 per slice; rolling hash is O(1) per step)  
**Space:** O(n) distinct 10-mers in the worst case

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

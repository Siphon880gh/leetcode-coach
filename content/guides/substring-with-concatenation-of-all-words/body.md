`words` are all the same length `k`. A hit is a substring that is some permutation of those words glued together (duplicates in `words` matter). Return every start index in `s`. Order of indices does not matter.

`"barfoothefoobarman"`, `["foo","bar"]` → `[0,9]`. `"wordgoodgoodgoodbestword"`, `["word","good","best","word"]` → `[]`.

Checking every start with a fresh count is O(starts × n × k). Align windows to word length instead.

## k residue classes

Need `cnt` = frequencies in `words`. For each offset `i` in `0..k-1`, slide `l` and `r` by `k` on that alignment.

Take the next chunk `s[r:r+k]`:

- Not in `cnt`: drop the window (`l = r`, clear counts).
- In `cnt`: increment. While that word is over-used, pop chunks from `l`.
- When the window length is exactly `n * k`, `l` is a valid start.

**Time:** O(|s| × k)  
**Space:** O(n × k) for the maps

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

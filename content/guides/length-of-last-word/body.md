Return the length of the last word: a maximal run of non-space characters. n ≤ 10⁴. At least one word exists.

`"Hello World"` → 5. `"   fly me   to   the moon  "` → 4. `"luffy is still joyboy"` → 6.

## Skip trailing spaces first

Start at `i = n-1`. While `s[i]` is a space, decrement `i` — the last characters may be padding. Then set `j = i` and walk left while `s[j]` is not a space. After that loop, `j` sits on the space (or just before the string), so `i - j` is the letter count.

Splitting on every space keeps empty tail tokens, so the last piece can have length 0. Measuring the whole string is wrong (`"Hello World"` is 11, the last word is 5). You do not need a trimmed copy or a word array — two indices from the right are enough.

**Time:** O(n)  
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

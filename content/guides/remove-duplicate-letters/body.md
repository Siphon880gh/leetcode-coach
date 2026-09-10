Lowercase `s`, length up to 10⁴. Drop duplicate letters so each letter appears once, and among those subsequences pick the **lexicographically smallest**. `"bcabc"` → `"abc"`. `"cbacdcbc"` → `"acdb"` (not `"abcd"` — you must keep a subsequence of `s`). Same problem as Smallest Subsequence of Distinct Characters (1081).

## Pop a larger top only if that letter still appears later

Sorting the unique letters would ignore order: `"cbacdcbc"` is not `"abcd"`. First unique scan also fails (`"bcabc"` would keep `"bca"`).

Record `last[c]` = last index of `c`. Walk `i`, letter `c`. If `c` is already in the stack, skip (a better earlier placement already won). Else while the stack is non-empty, the top is `> c`, and `last[top] > i` (the top will appear again), pop the top. Then push `c`. Join the stack.

You only pop when the letter is **not** on its last occurrence. `"c"` in `"cbacdcbc"` can leave the stack when `"a"` arrives because another `"c"` remains; `"d"` cannot be popped by a later smaller letter if this `"d"` is the last `"d"`.

Do not sort unique characters. Do not pop a letter that never appears again. Do not keep a letter that is already in the stack.

**Time:** O(n)  
**Space:** O(1) extra besides the stack (26 letters)

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

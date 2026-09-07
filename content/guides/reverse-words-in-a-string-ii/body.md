Character array `s`. Reverse the **order of words** in place — no extra buffer of words. A word is a run of non-spaces. Words are separated by exactly one space; no leading or trailing space; at least one word. Length up to 1e5. `['t','h','e',' ','s','k','y',' ','i','s',' ','b','l','u','e']` → `blue is sky the` as chars. `['a']` stays.

## Two reverses, not split-and-join

Reverse Words (151) may collect tokens and join. That uses extra space. Here you must mutate `s`. Reversing every character once would leave letters backward inside each word.

1. Reverse the whole array (`i` from the left, `j` from the right, swap while `i < j`). Words are now in the right order but each word is spelled backward.
2. Scan for spaces. Reverse each slice from the start of a word to the char before the next space. After the last space, reverse through the end (there is no trailing space).

Equivalent: reverse each word first, then reverse the whole array (same swaps, different order). Do not `split` / `join`. Two indices for a reverse is O(1) extra.

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

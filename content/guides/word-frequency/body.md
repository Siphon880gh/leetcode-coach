Count each word in `words.txt`. Lowercase letters and spaces only; one or more spaces between words. Print `word count` lines, highest count first. Each frequency is unique, so ties do not matter. Sample: four `the`, three `is`, two `sunny`, one `day`.

## One word per line, then count runs

Number of 1 Bits counts set bits. Group Anagrams hashes sorted letters. Combine Two Tables is SQL. Here the file is the input and Unix pipes are the algorithm.

Squeeze repeated spaces to a newline so each token is its own line (`tr -s` space to newline). `sort` puts equal words in a block. `uniq -c` emits a count and the word for each block. `sort -nr` orders those counts descending (numeric, reverse). `uniq -c` puts the number first; swap with `awk` so the line is word, then count.

Do not split on a single space only: the problem allows runs of whitespace. Do not sort alphabetically for the final order — the last sort is by frequency. A hash map in another language is the same idea; the one-liner is the pipe above.

**Time:** O(n log n) to sort the tokens  
**Space:** O(n)

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

8-letter gene strings over `A`, `C`, `G`, `T`. One mutation flips exactly one character. Every intermediate (except possibly `startGene`) must appear in `bank`. Return the fewest mutations from `startGene` to `endGene`, or `-1`. Bank size is at most 10. Start is valid even if it is missing from the bank.

`AACCGGTT` → `AACCGGTA` with bank `[AACCGGTA]` is 1. The second sample needs two hops: `AACCGGTT` → `AACCGGTA` → `AAACGGTA`.

## BFS on the bank

Queue `(gene, depth)` from `startGene` at 0. Mark visited. Pop; if the gene equals `endGene`, return depth. Else scan `bank` and enqueue any unused word whose Hamming distance is 1 (exactly one position differs). Exhausted queue → `-1`.

Word Ladder (127) is the same graph idea on a larger dictionary of English words (26 letters). Open the Lock (752) BFS-es 4-digit dials with deadends. Do not DFS the first path you find (it may be longer). Do not require `startGene` in `bank`. Do not count a 2-letter jump as one mutation. Do not skip marking visited (cycles on a 10-word bank still loop).

Time: O(n m) with n = 8, m = bank size  
Space: O(m)

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

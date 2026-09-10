Two integer lists `v1` and `v2`. `next()` / `hasNext()` return elements **alternately**: first of v1, first of v2, second of v1, …. When one list runs out, keep draining the other. `[1,2]` and `[3,4,5,6]` → `1,3,2,4,5,6`. One empty list still yields the other. Lengths up to 1000, at least one element in total. Follow-up: `k` lists in cyclic order (`[1,2,3]`, `[4,5,6,7]`, `[8,9]` → `1,4,8,2,5,9,3,6,7`).

## One cursor per list; skip spent lists

Flatten 2D Vector (251) walks **rows** in order (all of row 0, then row 1). Zigzag Conversion (6) writes a string in rows. Here you **round-robin** two (or k) sequences.

Store `vectors = [v1, v2]`, `indexes` all 0, `cur = 0`, `size = 2`. `hasNext`: remember `start = cur`. While the current list’s index equals its length, `cur = (cur + 1) mod size`. If `cur` returns to `start`, every list is spent → false. Else true (and `cur` now points at a list that still has an element). `next`: take `vectors[cur][indexes[cur]]`, bump that index, then `cur = (cur + 1) mod size`. Call `hasNext` before `next`.

A queue of (list-id, index) pairs is the same idea and extends to k lists: enqueue only lists that still have items; after emitting, re-enqueue if that list has more.

Do not concatenate v1 then v2 (that is not zigzag). Do not assume both lists have the same length. Do not use 251’s row-then-column scan.

**Time:** amortized O(1) per `next`/`hasNext`  
**Space:** O(k) indices (k = 2 here)

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

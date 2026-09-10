Each rectangle is `[x, y, a, b]`: bottom-left `(x, y)`, top-right `(a, b)`, axis-aligned. Return true iff the pieces form an exact cover of one larger rectangle — no gaps, no overlaps. Up to `2e4` rectangles. The five-piece example is true; a gap is false; an overlap is false.

## Bounding area, then corner parity

Add each rectangle’s area (width × height). Track `minX, minY, maxX, maxY`. If the total area is not the bounding-box area, there is a gap or an overlap (or both). Use a 64-bit accumulator: one rectangle can already overflow 32-bit ints.

Area can still match when a gap and an overlap cancel. Count every corner in a map. The four bounding-box corners must appear exactly once (they are the outer vertices). Remove those four, then every remaining point must appear 2 or 4 times (an edge T-junction or four rectangles meeting). A count of 1 or 3 at an interior point is a gap or a leftover corner from an overlap.

Rectangle Area (223) is the union of two rectangles. Rectangle Area II (850) is union area of many. This problem asks for an exact cover, not a union area.

Do not return true from area equality alone. Do not require every interior corner to appear four times (T-junctions are 2). Do not skip 64-bit area in languages with fixed ints.

Time: O(n)  
Space: O(n)

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

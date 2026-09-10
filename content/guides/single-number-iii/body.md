Exactly two values appear once; every other value appears twice. Return those two, any order. Linear time, **constant extra space**. `[1,2,1,3,2,5]` → `[3,5]`. `[-1,0]` → `[-1,0]`. Length 2 to `3 × 10⁴`.

## One XOR is a XOR b; lowbit splits the pair

Single Number (136) XOR-s everything because **one** leftover remains. Single Number II (137) is “appears three times.” A set of leftovers is O(n) extra and fails the space bound.

XOR the whole array into `xs`. Pairs cancel, so `xs = a XOR b`. Because `a ≠ b`, `xs` has at least one bit set. `lb = xs AND (−xs)` is that lowest set bit — a bit where `a` and `b` differ. Scan again: XOR values whose `x AND lb` is nonzero into `a`. That group contains exactly one of the singles (pairs with that bit still cancel). Then `b = xs XOR a`. Do not return `xs` as a single answer. Do not hash-count. Do not sort and scan adjacent equals (that is O(n log n)).

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

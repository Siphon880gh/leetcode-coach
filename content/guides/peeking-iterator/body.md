Wrap an existing integer iterator so `peek()` returns the next value **without** advancing, while `next()` and `hasNext()` still behave like a normal iterator. Sample `[1, 2, 3]`: `next` → 1, `peek` → 2 (pointer stays), `next` → 2, `next` → 3, `hasNext` → false. At most 1000 calls. All `peek` / `next` calls are valid. Follow-up: same design for any type, not only ints.

## One cached element and a has-peeked flag

Flatten 2D Vector walks a matrix with two indices. Zigzag Iterator round-robins lists. Nested Iterator (341) uses a stack. Here you only add **lookahead** on top of `Iterator.next` / `hasNext`. Do not copy the source array.

Keep `hasPeeked` (false) and `peekedElement`. `peek`: if not peeked, set `peekedElement = iterator.next()` and `hasPeeked = true`; return `peekedElement`. `next`: if not peeked, return `iterator.next()`; else clear the flag, drop the stash, and return the old stash. `hasNext`: `hasPeeked or iterator.hasNext()` — a leftover peek still counts after the inner iterator is spent.

Do not call `iterator.next()` on every `peek` (that would skip values). Do not implement `hasNext` as only `iterator.hasNext()` (a pending peek would look empty). Do not dump `nums` into your own list and ignore the given iterator.

**Time:** O(1) per call  
**Space:** O(1) extra

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

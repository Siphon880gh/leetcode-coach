Design `TwoSum`: `add(number)` and `find(value)` on a stream. `find` is true iff some pair (distinct uses of the stream) sums to `value`. Sample: add 1, 3, 5; `find(4)` is true (1+3); `find(7)` is false. At most 10⁴ calls.

## Count map; find walks complements

Two Sum I is one array, one query, and may use O(n) extra for a complement map once. Two Sum II is a sorted array with two pointers. Majority Element is Boyer-Moore. None of those keep a live stream.

`cnt` stores how many times each number appeared. `add`: `cnt[number] += 1` in O(1). `find`: for each key `x`, `y = value - x`. If `y` is in `cnt` and (`x != y` or the count of `x` is greater than 1), return true. Same-number pairs need two copies: `find(2)` after a single `add(1)` is false.

If no pair after the scan, false. `find` is O(n) in the distinct keys stored.

**Time:** O(1) add, O(n) find  
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

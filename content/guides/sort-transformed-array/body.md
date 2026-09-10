Sorted `nums`. Return `f(x) = a × x² + b × x + c` for every x, already in sorted order. `[-4,-2,2,4]` with `a=1, b=3, c=5` → `[3,9,15,33]`. Same nums with `a=-1` → `[-23,-5,1,7]`. Follow-up is linear time: do not map then sort.

## Parabola ends vs vertex

`f` is a parabola. `a > 0` opens upward: the vertex is a minimum, so on a sorted domain the ends of `nums` hold the two largest `f` values. `a < 0` opens downward: the ends hold the two smallest. `a = 0` is a line: still monotonic, so the smaller of the two ends is always the next smallest remaining value.

Two pointers `i` (left) and `j` (right). Compare `f(nums[i])` and `f(nums[j])`:

- If `a > 0`, write the larger into the answer from the back, then move that pointer inward.
- Else (`a ≤ 0`), write the smaller into the answer from the front, then move that pointer inward.

Repeat until the answer is full. Ties can take either end.

Do not binary-search the vertex and merge two sorted halves unless you want extra cases. Do not sort the transformed values (`O(n log n)`).

Time: O(n)  
Space: O(n) for the answer (or O(1) extra if you may overwrite a new array only)

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

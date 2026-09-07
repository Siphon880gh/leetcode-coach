`numbers` is sorted, 1-indexed. Return the two indices (already +1) that sum to `target`. Exactly one pair. Constant extra space. `[2,7,11,15]`, target 9 → `[1,2]`. `[2,3,4]`, target 6 → `[1,3]`. `[-1,0]`, target −1 → `[1,2]`. Length up to 3×10⁴.

## Close in from both ends; return 1-based indices

Two Sum I’s complement map is O(n) extra memory; this problem forbids that. 3Sum looks for three numbers. Fraction-to-decimal remainders are a different hash. The judge wants 1-based positions: `[1,2]`, not `[0,1]`.

Sorted order lets two pointers close in with O(1) extra space. `i` at 0, `j` at `n-1`. While `i < j`: `x = numbers[i] + numbers[j]`. Equal → return `[i+1, j+1]`. Too small → `i += 1`. Too big → `j -= 1`.

On `[2,7,11,15]` target 9, first `x` is 2+15=17. A sum above target means the right value is too large, so shrink `j`, not grow `i`. Then 2+7; return `[1,2]`. Binary search for each complement is O(n log n) and also O(1) extra; the two-pointer walk is O(n).

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

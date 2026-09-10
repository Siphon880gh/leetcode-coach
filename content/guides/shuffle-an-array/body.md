Array `nums` of unique ints, length 1..50. `reset()` returns the original order. `shuffle()` returns one permutation; all `n!` permutations must be equally likely. At most 1e4 mixed calls. Example: `[1, 2, 3]` shuffles to some permutation, reset is `[1, 2, 3]`, shuffle again is another permutation.

## Copy for reset, Fisher–Yates for shuffle

Store `original = nums.copy()`. `reset` copies `original` back into the working array. `shuffle`: for `i` from 0 to `n−1`, pick `j = randrange(i, n)` and swap `nums[i]` with `nums[j]`. After `i` is fixed, later steps never touch it, so each remaining suffix is a uniform permutation.

Picking `j` in `[0, n)` every time (including already-placed prefixes) is not uniform. Building a new list by repeatedly drawing from leftover indices with a set is correct but heavier. Insert Delete GetRandom (380) samples one member, not a full permutation. Linked List Random Node (382) is reservoir of size 1.

Do not shuffle `original` in place if you still need `reset`. Do not generate all `n!` permutations and pick one. Do not skip copying before the first shuffle if `reset` must restore the constructor input.

Time: O(n) per shuffle / reset  
Space: O(n) for the original copy

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

Given an array of integers `nums` and an integer `target`, return the indices of the two numbers that add up to `target`. You may assume exactly one solution, and you may not use the same element twice.

## Why brute force hurts

Checking every pair is `O(n²)` time. For interview and contest scale, that is usually too slow — and it wastes the structure of the problem: for each value `x`, you only need to know whether `target - x` already appeared.

Brute force is Time O(n²) · Space O(1). The hash map below is the interview goal.

## One-pass hash map

Walk the array left to right:

- At index `i`, compute `need = target - nums[i]`.
- If `need` is already in the map, return `[map[need], i]`.
- Otherwise store `nums[i] → i` and continue.

Each lookup and insert is amortized O(1), so the whole pass is **O(n)** time and **O(n)** extra space for the map. That space/time tradeoff is the pattern to remember for “find a pair / complement” array problems.

**Time:** O(n)  
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

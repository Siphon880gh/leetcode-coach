n stations on a circle. From `i` you gain `gas[i]` and spend `cost[i]` to reach `i+1`. Start with an empty tank. Return the **unique** start index that can complete one clockwise loop, or `-1`. `n` up to 1e5.

`[1,2,3,4,5]` vs `[3,4,5,1,2]` → `3`. `[2,3,4]` vs `[3,4,3]` → `-1`.

## Reset start when the tank goes negative

A full lap from every `i` is O(n²) and TLE at 1e5. Jump Game is a line and a boolean. Starting at the station with the most gas is index 4 on the first sample, but 4 cannot finish — 3 can. Kadane on diffs is a different problem. The judge wants a start index or `-1`, not true/false.

One pass: `tank += gas[i] - cost[i]`. If `tank < 0`, every start after the old start and at or before `i` would arrive at `i` with even less gas, so skip the whole failed stretch: next start is `i+1`, tank resets to 0. Also track the total surplus (or `sum(gas)` vs `sum(cost)`). Clockwise only; a solution is unique if it exists.

After the pass: if total surplus is negative, return `-1` even if a start index was recorded. Else return that start. Sample 1 starts at 3. Sample 2’s total is negative → `-1`. Unlimited tank capacity still starts empty — do not always return `0`.

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

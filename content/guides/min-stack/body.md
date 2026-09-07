Stack with `push`, `pop`, `top`, and `getMin`, each O(1). Sample: push -2, 0, -3; `getMin` is -3; pop; `top` is 0; `getMin` is -2. Pop/top/getMin only on nonempty.

## Twin stacks; pop in lockstep

A scan is O(n), not O(1). LRU is a cache. RPN is postfix eval. A single stored min is stale after you pop that min. The stack is not a rotated sorted array — you need O(1) after each mutating call, not log n search.

`stk1` holds values. `stk2` starts as `[inf]`. Push: `stk1.append(val)`; `stk2.append(min(val, stk2[-1]))`. Pop both. `top` is `stk1[-1]`; `getMin` is `stk2[-1]`. Each value has a matching running-min snapshot; dropping only `stk1` would desync `getMin`. After popping -3, `getMin` must become -2, not stay -3.

Duplicates are fine: a second copy of the min still has its own snapshot. With -3 on the stack, `getMin` is -3. After pop, `top` is 0 and `getMin` is -2.

**Time:** O(1) per op  
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

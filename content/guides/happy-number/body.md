Is `n` happy: replace it by the sum of the squares of its digits, repeat, and return true if you ever hit 1. If you loop in a cycle that is not 1, return false. `1 ≤ n ≤ 2³¹ − 1`. `19` → true (`82 → 68 → 100 → 1`). `2` → false.

## Record seen values; 1 wins, a repeat loses

Linked List Cycle finds a loop with Floyd on nodes. Bitwise AND of a range strips bits. Here the “next” pointer is a math map: peel `n % 10`, add that digit squared, `n //= 10`, until `n` is 0.

Keep a set `vis`. While `n` is not 1 and `n` is not in `vis`: insert `n`, then replace `n` with the digit-square sum. After the loop, return whether `n` is 1. `19` never repeats until 1. Unhappy numbers fall into `4 → 16 → 37 → 58 → 89 → 145 → 42 → 20 → 4`. Seeing a value twice means that cycle, not 1.

Do not recurse without a seen set: the chain is unbounded in theory and you would stack-overflow on a cycle. Do not stop at a fixed step count unless you prove every unhappy number hits 4. Floyd twin (no set): slow takes one next, fast takes two; they meet; return whether the meeting value is 1. Same cycle idea as Linked List Cycle, O(1) extra.

**Time:** O(log n) per next, few distinct values (the map collapses quickly)  
**Space:** O(k) for the set, or O(1) with Floyd

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

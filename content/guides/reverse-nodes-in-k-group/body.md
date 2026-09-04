Reverse every consecutive group of `k` nodes. If the last group is shorter than `k`, leave it. Do not rewrite `val`. `[1,2,3,4,5]`, k = 2 → `[2,1,4,3,5]`. Same list, k = 3 → `[3,2,1,4,5]`. Swap Nodes in Pairs is this problem with k = 2.

## Dummy, peek k, reverse the window

Dummy in front of `head`. `pre` is the node before the next window. From `pre`, walk `k` steps. If you hit null, return `dummy.next` (tail too short). Otherwise `cur` is the last node of the window. Cut `cur.next`, reverse the sublist that starts at `pre.next` (standard head-insert), attach that reversed head to `pre.next`, and attach the saved tail to the old window head (now the last node). Set `pre` to that old head and repeat.

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

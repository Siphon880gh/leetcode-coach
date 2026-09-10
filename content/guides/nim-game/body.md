Heap of `n` stones. You and a friend take turns; you go first. Each turn remove 1, 2, or 3 stones. The player who takes the last stone wins. Both play optimally. True iff you can force a win. `n = 4` → false. `n = 1` → true. `n = 2` → true. `n` up to `2³¹ − 1`.

## Losing positions are multiples of 4

Minimax / DP over remaining stones is correct but too slow for this range. Stone Game (877) is a different pile game. Here the period is 4 because the move size is 1..3.

If `n < 4`, take all remaining stones and win. If `n = 4`, every move leaves 3, 2, or 1, and the opponent takes the rest. If `n` is 5, 6, or 7, take 1, 2, or 3 so the opponent faces 4. Induct: a multiple of 4 is a losing seat — whatever you subtract in `{1, 2, 3}`, the opponent can add the complement to 4 and hand you another multiple of 4. Otherwise you can always move onto a multiple of 4.

So `return n % 4 != 0`. Do not loop down to 0. Do not confuse “take the last stone” with a misère rule (here last stone **wins**). Do not treat `n = 0` as a start (`n ≥ 1`).

**Time:** O(1)  
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

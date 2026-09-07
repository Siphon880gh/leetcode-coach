From index 0, `nums[i]` is the **maximum** hop you may take (any landing in `1 .. nums[i]`). Return whether you can reach the last index. n ≤ 10⁴.

`[2,3,1,1,4]` → true (0 → 1 → 4). `[3,2,1,0,4]` → false (every path dies at the 0).

## Farthest index, not hop count

Keep `mx`, the farthest index any earlier landing can still reach. Walk left to right. If `mx < i`, you never arrived at `i`, so later cells are also cut off — return false. Otherwise fold in this pad: `mx = max(mx, i + nums[i])`. If the scan finishes, return true.

`nums[i]` is a cap, not a required stride: a shorter hop onto a better pad is legal. A 0 is only a wall when it sits beyond every prior reach (`[2,0,0]` is true). Jump Game II asks for the **minimum hop count**; here you only need boolean reach, so one `mx` pass is enough. Nested “try every landing” DP is O(n²) and unnecessary.

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

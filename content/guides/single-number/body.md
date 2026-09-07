Every value appears twice except one. Return that single. Linear time and O(1) extra space.

`[2,2,1]` → `1`. `[4,1,2,1,2]` → `4`. `[1]` → `1`.

## XOR everything; pairs vanish

A hash set of leftovers is O(n) extra. Sort then scan is O(n log n). A frequency map is also extra O(n). Candy’s two slopes and Gray code’s `i XOR (i>>1)` are different problems. Single Number II is “appears three times,” not twice.

`x XOR x` is `0` and `x XOR 0` is `x`, so pairs cancel and the leftover is the answer. `ans = 0`; for each `v`, `ans ^= v`. Order does not matter: XOR is associative and commutative. Start at `0` because `0` is the identity — XOR with `0` does not wipe a value; starting at `0` or at `nums[0]` both work.

Return the final `ans` after XOR-ing the whole array — the unpaired integer, not a count of singles (there is exactly one).

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

Sorted linked list: each value once. Up to 300 nodes.

`[1,1,2]` → `[1,2]`. `[1,1,2,3,3]` → `[1,2,3]`.

## Keep one of each value

List II drops both 3s. Array compact returns `k`. Here you keep a single 1, a single 2, a single 3. Adjacent equals are collapsed, not erased as a group.

`cur = head`. While `cur` and `cur.next`: if equal, `cur.next = cur.next.next` and stay (three 1s in a row would otherwise keep two). Else `cur = cur.next`. No dummy: the first node of each run stays, including `head`. Return `head`.

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

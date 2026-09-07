Deep-copy a list where each node has `next` and `random` (`random` may be null). New nodes must not point at originals. Empty `head` → `None`.

`[[7,null],[13,0],[11,4],[10,2],[1,0]]` clones the same shape.

## Map old to new, then wire random

Copying only `next` and leaving `random` on the originals is a shallow copy — judges check node identity. Clone Graph walks an undirected neighbor list. XOR (Single Number) is unrelated. Setting `next` and `random` in one pass fails when `random` skips ahead: the target clone may not exist yet.

Use a hash map `d` from original to clone. Dummy + `tail`: for each `cur`, `d[cur] = Node(cur.val)`, stitch `tail.next`. Values are copied here. Then a second pass: `d[cur].random = d[cur.random]` if `cur.random` else `None`. Random can point anywhere, including backward, so every clone must exist before you wire `random`. The second pass does not recopy `val`.

Return `dummy.next` (the cloned head), not `dummy` and not the original `head`. `None` in, `None` out. Interleaving orig-copy-orig (O(1) extra) also works; the hash map is the writeup’s first solution.

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

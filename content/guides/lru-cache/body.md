Cache of `capacity`. `get(key)` is the value or `-1`. `put` updates or inserts and evicts the least recently used when over capacity. `get` and `put` O(1). Sample capacity 2: `get 1` after putting 1 and 2 is 1; `put 3` evicts 2.

## Map plus dummy head/tail

A plain dict cannot tell which key is oldest. FIFO ignores `get` as a use. A list scan is not O(1). Copy List’s random map and tree preorder are different problems. Head is most recent in this layout, so evicting `head.next` drops the hot key. Floyd finds cycles, not LRU.

Hash `key` → node. Dummy sentinels avoid empty-list edge cases. Move accessed nodes to the head; evict `tail.prev`. O(1) unlink from the middle of a DLL, plus the map to find the node.

`get`: miss → `-1`; hit → `remove_node`, `add_to_head`, return `val`. A hit must move the node or it is not LRU. `put`: if present, update `val` and move to head; else insert at head, and if size exceeds capacity pop `tail.prev` from the map and unlink it. Store `key` on the node: eviction starts from the list node; you need the key to delete the map entry. A node with only `val` cannot `cache.pop` in O(1).

After the sample, `get 3` is 3 and `get 4` is 4; 1 and 2 are gone.

**Time:** O(1) per op  
**Space:** O(capacity)

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

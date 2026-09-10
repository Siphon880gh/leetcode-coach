Round-trip a binary tree through a string. Nodes 0..10⁴, values −1000..1000. `[1,2,3,null,null,4,5]` round-trips. Empty tree → empty string. Any format is legal; LeetCode’s level-order with `null` is one option.

## Queue the children, including holes

Encode and Decode Strings (271) prefixes **list** lengths. Serialize BST (449) can skip nulls because BST order reconstructs shape. A general binary tree needs **sentinels**.

Serialize: if `root` is null, return `""`. Else BFS. For each dequeued node, if it exists append `str(val)` and enqueue left and right (even if null); if it is null, append `#`. Join with commas.

Deserialize: empty → `None`. Split on commas. First token is the root. Queue of **built** nodes. For each dequeued node, take the next two tokens as left and right: `#` means null (do not enqueue); otherwise build a child and enqueue it.

Do not omit `#` (then `[1,null,2]` and `[1,2]` collide). Do not `eval` a Python tree. Do not inorder-only (structure is lost without extra data).

**Time:** O(n)  
**Space:** O(n) for the string and the queue

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

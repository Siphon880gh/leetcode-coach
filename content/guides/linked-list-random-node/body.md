Singly linked list of length 1..1e4. `getRandom()` returns a node value; every node equally likely. At most 1e4 calls. Example list `[1, 2, 3]`: each of 1, 2, 3 has probability 1/3. Follow-up: the list may be huge and the length unknown — no extra array of values.

## Reservoir of size 1

Keep `ans` and a counter `k` starting at 0. Walk from `head`. For each node, increment `k` and with probability `1/k` set `ans = node.val`. Equivalently: draw `randint(1, k)` and replace when the draw equals `k`. After the tail, `ans` is uniform.

Proof sketch: node 1 is chosen first; node 2 replaces it with 1/2; node 3 with 1/3, and so on. The probability node `i` survives all later replacements is `(1/i) × (i/(i+1)) × … × ((n−1)/n) = 1/n`.

Copying every value into an array then picking `arr[rand(n)]` is O(1) per call but uses O(n) extra space, which the follow-up forbids. Random Pick Index (398) uses the same 1/k replacement among matching indices. Insert Delete GetRandom (380) needs an indexable bag you already own, not a one-pass unknown-length stream.

Do not pick `head` with a fixed coin that ignores later nodes. Do not assume you stored `n` unless you counted it. Do not skip a node after you have already committed an answer.

Time: O(n) per getRandom
Space: O(1) extra (follow-up)

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

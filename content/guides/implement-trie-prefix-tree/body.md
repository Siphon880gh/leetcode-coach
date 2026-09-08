Prefix tree: `insert(word)`, `search(word)` (true only if that full word was inserted), `startsWith(prefix)` (true if some inserted word has that prefix). Lowercase letters. At most `3×10⁴` mixed calls. After `insert("apple")`: `search("apple")` true, `search("app")` false, `startsWith("app")` true; then `insert("app")` makes `search("app")` true.

## Walk 26 slots; mark the last node

LRU Cache hashed keys to list nodes. Here each character is an edge. A node holds `children[26]` (index `c − 'a'`) and `isEnd`. The Trie object is the root.

`insert`: from the root, for each letter, create the child if missing, then step there. After the last letter, set `isEnd = true`. Shared prefixes share nodes: `"apple"` then `"app"` only flips `isEnd` on the third node.

Walk a string the same way. If a child is missing, return null. `startsWith` is true iff that walk finishes. `search` is true iff it finishes **and** `isEnd` is true — otherwise `"app"` is only a prefix of `"apple"`.

Do not store a set of whole words and scan for prefixes (too slow on 3×10⁴ calls). Do not treat `startsWith` as `search`. Hash-map children instead of 26 slots is the same idea when the alphabet is sparse.

**Time:** O(m) per op for word length m  
**Space:** O(total characters inserted times 26) in the array-child layout

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

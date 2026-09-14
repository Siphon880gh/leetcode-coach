Design `AllOne`: `inc(key)`, `dec(key)`, `getMaxKey()`, `getMinKey()`. Keys are lowercase, length 1 to 10. At most 5e4 calls. Every method must be average constant time. `dec` is only called on a key that exists. Empty structure → `""` for min/max.

## Count buckets, circular dummy

Keep `nodes[key] →` the bucket that currently holds that key. Buckets sit in a circular doubly linked list around a dummy: `dummy.next` is the smallest count, `dummy.prev` the largest. Each bucket stores `cnt` and a set of keys.

`inc`: new key joins count 1 (create that bucket if dummy.next is not 1). Existing key leaves its bucket and joins `cnt+1` (create if the next bucket is not exactly that). Drop an empty bucket.

`dec`: count 1 removes the key. Otherwise move to `cnt-1` (create if needed). Drop an empty bucket.

`getMaxKey` / `getMinKey`: peek any key in `dummy.prev` / `dummy.next`.

LFU Cache (460) also uses frequency lists but evicts. LRU Cache (146) is recency, not count. Max Frequency Stack (895) is a stack of frequencies, not min and max keys. Do not scan all keys. Do not leave an empty bucket in the list (min/max would see it). Do not skip creating a bucket when counts jump (1 then 3 with nothing at 2 is fine; 1 to 2 must exist as a node when someone sits at 2).

Time: O(1) per call  
Space: O(number of keys)

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

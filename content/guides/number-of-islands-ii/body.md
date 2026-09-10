Empty `m` by `n` water grid. `positions[k] = [r, c]` turns that cell into land. Return, after each op, how many 4-connected islands exist. `m=n=3`, `[[0,0],[0,1],[1,2],[2,1]]` → `[1,1,2,3]`. Duplicate land ops leave the count unchanged. `m`, `n`, and `k` up to 10⁴, with `m × n` also ≤ 10⁴.

## Union-find online, not flood-fill 200

Number of Islands (200) DFS/BFS-paints a **static** grid. Re-running 200 after every add is O(k m n) and fails the follow-up. Here land arrives over time.

Flatten cell `(i, j)` to id `i × n + j`. Union-find on `m × n` slots, path compression + union by size. Keep a land grid (or a set of land ids) and `cnt`. For each position:

- Already land → append `cnt`, skip.
- Else mark land, `cnt += 1`, then for each 4-neighbor in bounds that is land: if `union(this, neighbor)` merged two roots, `cnt -= 1`.
- Append `cnt`.

A merge only happens when the neighbor was a **different** island; two neighbors of the same island must not decrement twice (union returns false). Diagonals do not connect. Four edges are water.

Do not flood the whole grid per op. Do not 8-connect. Do not skip the duplicate-land short circuit (would double-count).

**Time:** O(k α(m n)) with path compression (or O(k log(m n)))  
**Space:** O(m n)

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

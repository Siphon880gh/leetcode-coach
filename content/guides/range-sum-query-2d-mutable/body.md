`m` by `n` matrix that **changes**. `update(row, col, val)` sets a cell. `sumRegion(r1, c1, r2, c2)` is inclusive. Sample rectangle 8, then `update(3,2,2)` → 10. Up to 200 by 200; 5000 mixed calls.

## Per-row Fenwick, not a 304 prefix

Range Sum Query 2D - Immutable (304) is include-exclude on a padded prefix — O(1) query, **no** updates. Range Sum Query - Mutable (307) is one 1-D Fenwick. Here you need both.

Doocs Solution 1: a Binary Indexed Tree **per row**. Build each row like 307. `update`: delta = `val` minus the current cell (query that row’s prefix at `col+1` minus prefix at `col`), then point-update that row’s tree at `col+1`. `sumRegion`: for each row in `[r1, r2]`, add `query(c2+1) − query(c1)`. Update O(log n); query O(m log n), fine at m ≤ 200.

A 2-D BIT (nested `lowbit` on row and column) makes both ops O(log m log n). Scanning the rectangle per query is O(m n) and fails 5000 calls at 200².

Do not reuse 304’s static `s`. Do not forget Fenwick is 1-indexed. Do not drop the include-exclude plus on a 2-D BIT query.

**Time:** O(m n log n) build; O(log n) update / O(m log n) query (per-row), or O(log m log n) both (2-D BIT)  
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

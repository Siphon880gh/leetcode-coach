Numbers factor as products. `8 = 2 × 2 × 2 = 2 × 4`. Given `n`, return **all** combinations of factors, each factor in `[2, n − 1]`, any order of lists. `12` → `[[2,6],[3,4],[2,2,3]]`. `1` and primes (for example `37`) → `[]`. `1 ≤ n ≤ 10⁷`.

## Split remain; start the next factor at the last one

Combination Sum (39) **adds** candidates to a target. This problem **multiplies** factors to `n`. Prime factorization is one list (the primes); here every grouping counts: `2 × 6` and `2 × 2 × 3` are both answers for `12`. The trivial `[n]` is **not** a combination — factors must be strictly smaller than `n`.

`dfs(remain, start)` with a path `t`. If `t` is already non-empty, record `t + [remain]` (the leftover product is a valid last factor, and it is `≥ start` because you only recurse when `start × start ≤ remain`). Then try `j` from `start` while `j × j ≤ remain`. When `remain` is divisible by `j`, push `j` and recurse `dfs(remain / j, j)` so the next factor is at least `j` (non-decreasing; `[2,2,3]` appears once, not `[3,2,2]`). Pop and try the next `j`. Start with `dfs(n, 2)` and `t` empty — the first record never fires, so `[n]` never lands in the answer.

Do not loop `j` up to `remain` (that reintroduces `[n]` and reversed pairs). Do not emit only the prime factorization. Do not treat `1` as a factor.

**Time:** worst-case search over factor trees of `n` (small in practice; `n` has few factors)  
**Space:** O(log n) path depth

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

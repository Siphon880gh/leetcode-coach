How many primes are **strictly less than** `n`. `0 ≤ n ≤ 5×10⁶`. `10` → `4` (2, 3, 5, 7). `0` and `1` → `0`.

## Mark multiples; count what stays true

Happy Number mapped digits. Factorial trailing zeroes counted fives. Here you need every prime below `n`, and `n` can be five million — trial-dividing each `i` up to `√n` times out.

Sieve of Eratosthenes: an array `primes` of length `n`, all true (index is the number). Loop `i` from 2 through `n − 1`. If `primes[i]` is still true, `i` is prime: add 1 to the answer, then walk `j = i + i, i + 2i, …` while `j < n` and set `primes[j] = false`. Start the inner walk at `2i`, not `i`, so you do not un-count the prime itself. 1 is never visited. Empty range when `n < 2` yields 0.

Do not include `n` even if `n` is prime. Do not treat 1 as prime. Starting the inner loop at `i × i` is a common speedup (smaller composites already fell to a smaller factor); starting at `2i` is the same correctness, slightly more writes.

**Time:** O(n log log n)  
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

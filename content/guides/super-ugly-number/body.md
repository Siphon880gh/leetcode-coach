A super ugly number is a positive integer whose prime factors all sit in `primes`. Return the **nth** one (`n` up to 10⁵; it fits in a 32-bit signed int). `primes` is unique, sorted, length up to 100. Sample `n = 12`, `primes = [2,7,13,19]` → `32` (sequence `1,2,4,7,8,13,14,16,19,26,28,32`). `n = 1` → `1` (no prime factors).

## Same merge as Ugly Number II, k lanes

Ugly Number (263) tests one integer. Ugly Number II (264) merges three streams (`× 2`, `× 3`, `× 5`). Here the stream count is `k = len(primes)`.

`dp[0] = 1`. Keep `ptr[i] = 0` for each prime. For the next slot, take `min` of `dp[ptr[i]] × primes[i]`. Write that min, then increment **every** `ptr[i]` whose candidate equals it, so `2 × 7` and `7 × 2` do not duplicate 14. Time O(n k).

Heap twin: start with `1`. Pop the smallest `x`, n times. Push `x × p` for each prime `p` if it stays ≤ 2³¹ − 1. To skip duplicates, after a prime `p` divides `x`, stop later primes (Euler-style: generate each value from its smallest factor once). Java also drains equal heads after a pop.

Do not trial-divide every integer up to the answer. Do not freeze the factors at 2, 3, 5. Do not bump only the first matching pointer.

**Time:** O(n k) DP; heap is larger by a log of the queue  
**Space:** O(n) plus k pointers (or the heap)

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

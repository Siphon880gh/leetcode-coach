Return whether integer `n` equals `2ˣ` for some integer `x`. `1` → true (`2⁰`). `16` → true. `3` → false. Range includes negatives: `-2³¹ ≤ n ≤ 2³¹ − 1`. Follow-up: no loop, no recursion.

## One set bit, and n must be positive

Number of 1 Bits (191) counts how many times `n AND (n minus 1)` can fire. Here you need that count to be exactly one. Power of Three (326) divides by 3; Power of Four (342) also checks the 1 sits on an even bit. Repeated `n % 2 == 0` then `n /= 2` works for positives but is a loop; `n == 0` and negatives must be false (`-16` is not `2ˣ` in this problem).

`n > 0` and `(n & (n - 1)) == 0`. The AND clears the lowest 1. If nothing remains, there was only one 1, so `n` is a power of two. `1` is `0b1`. `16` is `0b10000`. `3` is `0b11` and the AND yields `2`. Do not skip the `n > 0` test: in two’s complement a negative can look “sparse.” Do not use floating `log2` equality (rounding).

**Time:** O(1)  
**Space:** O(1)

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

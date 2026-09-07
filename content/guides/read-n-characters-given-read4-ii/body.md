Same `read4` API as Read N Given Read4, but `read(buf, n)` may be called many times on one file. File `abc`, queries `[1,2,1]` → `[1,2,0]`. `[4,1]` → `[3,0]`. Reset instance state between test cases. File length 1 to 500; up to 10 queries.

## Drain leftovers before the next read4

Read4 I is called once, so leftover in that 4-block can be ignored. Here `read(1)` then `read(2)` on `abc` must still see `b` and `c`. You still cannot index the file. Reverse Words is a different string problem.

Keep `buf4`, `i`, and `size` on the object. Refill only when `i == size`. `read4` advances the file pointer; calling it again after you only consumed 1 of 4 drops the rest.

While `j < n`: if `i == size`, `size = read4(buf4)`; `i = 0`; if `size == 0` break (EOF). Then copy while `j < n` and `i < size`. Return `j`.

Break when `size` is 0: further `read4` stays empty; return how many you already wrote (maybe 0). Spinning after EOF does not fill `n`.

`abc` with `[1,2,1]`: first call copies `a` and leaves `bc` in `buf4`; second drains `bc`; third gets `size` 0 and returns 0. `[4,1]` takes the whole file on the first call, then EOF.

**Time:** O(n) per call  
**Space:** O(1) extra (the 4-slot plus two indices)

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

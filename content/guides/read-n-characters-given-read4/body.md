You may only call `read4(buf4)`, which copies up to 4 file characters and returns how many. Implement `read(buf, n)`: write up to `n` characters into `buf`, return the count written. Called once per test. File `abc`, `n=4` → 3. `abcde`, `n=5` → 5. `buf` is large enough for `n`. File length 1 to 500; `n` up to 1000.

## Copy from each 4-slot until n or a short read

You cannot index the file. Reverse Words is string splitting. Upside Down is a tree rewire. Read4 II keeps leftover unread characters across multiple `read` calls; this problem’s `read` runs once, so you do not stash leftovers.

`i = 0`; a 4-slot `buf4`. Seed `v = 5` so the first loop runs. While `v` is still 4: `v = read4(buf4)`; for each of the `v` characters, `buf[i] = buf4[j]`; `i += 1`; if `i >= n` return `n`. After a short read, return `i` (EOF).

Copy one by one and stop as soon as `i` reaches `n`. `buf` is sized for `n`; copying all 4 when `n - i` is 1 overwrites past the request. For `n=2` you take two of the first four. For `n=5` you copy 4 then 1 and stop.

Return `n` early: you already filled the request; more `read4` would skip unread file bytes you do not need this call. If the file is shorter than `n`, `v < 4` ends the loop and you return `i < n`. `abc` with `n=4` returns 3, not 4.

**Time:** O(n)  
**Space:** O(1) extra (the 4-slot)

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

Intervals `[start, end)`, length 1 to 1e5. Starts and ends in −5e4 to 5e4, start strictly less than end. Return the fewest intervals to delete so the rest do not overlap. Two intervals that only share an endpoint (`[1,2]` and `[2,3]`) are non-overlapping.

`[[1,2],[2,3],[3,4],[1,3]]` → 1 (drop `[1,3]`). Three copies of `[1,2]` → 2. Already touching `[1,2],[2,3]` → 0.

## Sort by finish; keep if it starts after (or at) last end

Sort by right end. `pre` starts at −inf. Walk left-to-right: if `start >= pre`, keep it and set `pre = end`; else it overlaps a kept interval, so drop it. Count of drops is `n` minus the keep count (the doocs code starts `ans = n` and decrements on each keep).

Why earliest finish: a kept interval that ends sooner leaves more room for later ones, so you maximize keeps (classic activity selection). Merge Intervals (56) unions overlaps instead of counting deletions. Minimum Number of Arrows to Burst Balloons (452) uses the same sort-by-end walk but counts arrows, not removals. Meeting Rooms (252) asks whether any overlap exists.

Do not sort only by start (a long early interval can steal later slots). Do not treat endpoint-touch as overlap. Do not keep both of two identical `[1,2]`s.

Time: O(n log n)  
Space: O(1) besides the sort

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

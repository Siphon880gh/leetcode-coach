A watch with 4 LEDs for hours (`0`–`11`) and 6 for minutes (`0`–`59`). `turnedOn` is how many LEDs are lit (`0`–`10`). Return every valid time as `H:MM`: hour has no leading zero (`1:00`, not `01:00`); minutes are two digits (`10:02`, not `10:2`). Order does not matter. `turnedOn = 1` → `0:01`, `0:02`, `0:04`, `0:08`, `0:16`, `0:32`, `1:00`, `2:00`, `4:00`, `8:00`. `turnedOn = 9` → empty: nine 1-bits cannot make both `h < 12` and `m < 60`.

## Loop hours and minutes; keep a pair when popcounts add to n

For `h` in `0..11` and `m` in `0..59`, keep the pair if the number of 1-bits in `h` plus the number of 1-bits in `m` equals `turnedOn`. Format with a 2-digit minute. That is 720 checks, constant.

The same idea as a 10-bit mask: high 4 bits hour, low 6 bits minute. Walk `0 .. 2¹⁰ − 1`, skip illegal hours or minutes, keep masks whose popcount is `turnedOn`. Backtracking over which LEDs are on is equivalent and slower to write.

Number of 1 Bits (191) counts bits of one integer. Letter Combinations (17) is keypad DFS, not a clock. Gray Code (89) lists bit strings, not times.

Do not emit `01:00` or `10:2`. Do not allow `h ≥ 12` or `m ≥ 60` even if the bit count matches. Do not assume `turnedOn = 0` is empty — that is `0:00`.

Time: O(1)  
Space: O(1) extra besides the answer

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

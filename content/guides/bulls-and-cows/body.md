Secret and guess, same length, digits only. Return `"xAyB"`: `x` bulls (correct digit **and** position), `y` cows (right digit, wrong position). Cows are a rearrangement of the **non-bull** leftovers. `"1807"` / `"7810"` → `"1A3B"`. `"1123"` / `"0111"` → `"1A1B"` (only one leftover `1` in secret can pair). Length up to 1000.

## Count bulls first; cows are min of leftover bags

Guess Number / First Bad Version is a different API. Here you score one pair of strings. A permutation of the whole guess would mix bulls into cows.

Zip the two strings. Equal pair → increment bulls. Unequal pair → increment `cnt1[secret digit]` and `cnt2[guess digit]`. Then cows = sum over digits of `min(cnt1[d], cnt2[d])`. Return `f"{x}A{y}B"`.

Do not count a bull digit again as a cow. Do not let two guess `1`s share one secret `1` (`"1123"` / `"0111"`). Do not require unique digits.

**Time:** O(n)  
**Space:** O(1) — ten digit buckets

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

A row of `n` houses. Each house is red, blue, or green; neighbors cannot share a color. `costs[i][0/1/2]` is the price of that color on house `i`. Return the min total. `[[17,2,17],[16,16,5],[14,3,19]]` → 10 (blue, green, blue: 2 + 5 + 3). One house → that house’s cheapest color. `n ≤ 100`.

## Three states, not House Robber’s skip/take

House Robber (198) forbids adjacent **takes**. Here every house is painted; the constraint is **color**. Greedy “min of each row” can paint two neighbors the same cheap color. Paint House II generalizes to `k` colors; with three, three integers are enough.

Start `a = b = c = 0` (min totals ending red / blue / green after zero houses). For each row `(ca, cb, cc)` assign **together**:

`a, b, c = min(b, c) + ca, min(a, c) + cb, min(a, b) + cc`

The new red total cannot use the old red (same color next door). After the last house, return `min(a, b, c)`. Copy the old triple first if you update in place. Do not recurse into all 3ⁿ colorings. Do not allow two adjacent houses the same color even if it is cheaper.

**Time:** O(n)  
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

Each list is a non-negative integer stored **least-significant digit first**. `[2,4,3]` is 342, `[5,6,4]` is 465, and the sum `[7,0,8]` is 807. You cannot fold the lists into machine integers: each list can be 100 digits.

Treat a missing node as digit `0`. That covers unequal lengths without a second cleanup pass.

## Simulation

Keep a dummy head so you never special-case the first digit. Walk while `l1`, `l2`, or a leftover carry is still live:

1. `s = (l1 digit or 0) + (l2 digit or 0) + carry`
2. Append a node with `s % 10`
3. Set `carry = s // 10` (0 or 1)
4. Advance whichever lists still have a next node

`9 + 9` with both lists exhausted still needs one more loop because `carry` is 1 — that writes the leading `1` (`[8,1]`).

**Time:** O(max(m, n)) — one visit per digit.  
**Space:** O(1) extra besides the output list (dummy + a few pointers).

## Steps on `[2,4,3] + [5,6,4]`

- `2+5+0 → 7`, carry 0
- `4+6+0 → 10`, write 0, carry 1
- `3+4+1 → 8`, carry 0
- Result `[7,0,8]`

On `[9,9,9,9,9,9,9] + [9,9,9,9]`, keep looping after the shorter list ends so leftover nines plus carry become `[8,9,9,9,0,0,0,1]`.

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

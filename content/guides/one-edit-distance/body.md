True iff `s` and `t` differ by exactly one insert, delete, or replace. `ab` vs `acb` → true. Empty vs empty → false. Lengths up to 10⁴. Letters and digits.

## First mismatch, then the suffixes

Edit Distance (Levenshtein) asks for the min count and uses a DP table. Here we only need exactly one. Equal strings are zero edits, so false. Intersection of lists is a pointer identity trick, not strings.

If `s` is shorter, swap so `s` is the longer string. If `m - n > 1`, return false. Walk `i` over `t`. If `s[i] != t[i]`: replace when `m == n` (`s[i+1:] == t[i+1:]`); else delete from `s` (`s[i+1:] == t[i:]`). If the loop finishes, return `m == n + 1` (the extra char is at the end of `s`).

For `ab` vs `acb` after the swap, `s` is `acb`. At the first mismatch, `s[1]` is `c` vs `t[1]` is `b`; lengths differ so compare `s[2:]` with `t[1:]` — `b` vs `b`, true. Lengths 3 and 2 mean insert or delete, not replace. Replace needs equal lengths.

Empty vs empty: no mismatch, `m == n + 1` is false. Zero edits is not one.

**Time:** O(m)  
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

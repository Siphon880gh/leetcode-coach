Same length `s` and `t`. Can you replace characters of `s` to obtain `t`? Every occurrence of a character maps to the same character; two different characters cannot map to one target; a character may map to itself. ASCII. Length up to `5×10⁴`. `egg` / `add` → true. `paper` / `title` → true. `f11` / `b23` → false (`1` would need both `2` and `3`).

## Forward map and reverse map

Group Anagrams hashed a sorted key. Happy Number recorded seen values. Here you need a **bijection** between the alphabets of `s` and `t`, in lockstep.

Walk index `i`. Let `a = s[i]`, `b = t[i]`. Two dicts: `d1` (`s` → `t`) and `d2` (`t` → `s`). If `a` is already in `d1` and `d1[a] ≠ b`, fail. If `b` is already in `d2` and `d2[b] ≠ a`, fail (the `ab` / `aa` trap: `a` and `b` both want `a`). Else store both directions. Finish the walk → true. One map only is not enough.

Array twin (256 slots): remember the last index of each byte in `s` and in `t` (store `i + 1` so 0 means unseen). If those last-seen values differ, the pairing is inconsistent. Same O(n) pass, O(1) extra for ASCII.

Do not sort the strings. Do not require the mapping to be the identity. Lengths are already equal.

**Time:** O(n)  
**Space:** O(C) with C = 256, or the distinct characters in the maps

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

Group strings that belong to the same wrap-around Caesar sequence: every letter steps the same number of places, `z` wraps to `a`. Order of groups does not matter. Lowercase only. Up to 200 strings, each length 1..50. `["abc","bcd","acef","xyz","az","ba","a","z"]` → groups `{abc,bcd,xyz}`, `{az,ba}`, `{a,z}`, `{acef}`.

## Normalize the first letter to a

Group Anagrams (49) keys on a **sorted** letter multiset. Here two strings match iff their consecutive gaps (mod 26) match. A cheap fingerprint: left-shift the whole word so `s[0]` becomes `a`. `diff = s[0] − 'a'`. Each char minus `diff`; if it falls below `'a'`, add 26. `"bcd"` → `"abc"`. `"xyz"` → `"abc"`. `"ba"` → `"az"` (same key as `"az"`).

Hash map from that key to a list of original strings. Return the lists. A tuple of `(s[i] − s[0]) mod 26` is the same idea without building a string.

Do not key on sorted letters (`"abc"` and `"cba"` are not shifts of each other). Do not group by length alone (`"acef"` is length 4 and stays a singleton). Do not skip the wrap (`"za"` must meet `"ab"`).

**Time:** O(L) where L is the total number of characters  
**Space:** O(L)

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

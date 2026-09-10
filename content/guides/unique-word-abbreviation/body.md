Abbreviation of a word: first letter, count of letters between first and last, last letter. Length under 3 stays itself. `dog` → `d1g`. `internationalization` → `i18n`. `it` → `it`. `ValidWordAbbr(dictionary)` then `isUnique(word)`: true if no dictionary word shares that abbr, **or** every dictionary word with that abbr is the same string as `word`. Sample `["deer","door","cake","card"]`: `dear` false (`d2r` vs `deer`), `cart` true (no `c2t`), `cane` false (`c2e` vs `cake`), `make` true, `cake` true (only `cake` has `c2e`). Dictionary up to 3×10⁴, 5000 queries.

## Set per abbreviation, not a count

Trie (208) indexes prefixes. Generalized Abbreviation enumerates every way to abbreviate one word. Here you index the **dictionary** by one canonical abbr.

`abbr(s)`: if `len(s) < 3` return `s`; else `s[0] + str(len(s) − 2) + s[-1]`. Build `map[abbr] → set of words` (a set so duplicate dictionary entries collapse). `isUnique(word)`: let `s = abbr(word)`. True if `s` is missing, or the set’s only element is `word`. Python’s `all(word == t for t in set)` is the same as “size 1 and contains word.”

Do not return false just because `word` itself is in the dictionary (`cake` is unique). Do not treat `deer` and `door` as the same key (`d2r` vs `d2r` — they **do** collide; `d2r` is not unique). Do not store a single word per abbr and overwrite (`deer` then `door` would hide the conflict).

**Time:** O(n) build for n dictionary words; O(1) per `isUnique`  
**Space:** O(n)

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

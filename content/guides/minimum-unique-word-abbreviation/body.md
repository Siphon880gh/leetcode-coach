`target` length `m` is 1 to 21. `dictionary` has up to 1000 other lowercase words. Return a shortest abbreviation of `target` that is not a valid abbreviation of any dictionary word (any shortest is fine). Abbreviation length = kept letters plus the count of replaced runs (`s10n` has length 3). Adjacent runs are illegal, same as 320. `apple` / `[blade]` → `a4`. `apple` / `[blade,plain,amber]` → `1p3` (or `2p2` / `3l1`).

## Diff masks, then every keep-mask

Only same-length dictionary words can share an abbreviation. If none remain, the shortest unique form is just the decimal `m`.

For each remaining word, a bitmask marks indices where it differs from `target` (`apple` vs `blade` is four 1-bits then a 0). A candidate keep-mask (bit 1 = keep that letter) is unique iff it has a 1 overlapping every diff mask: you kept at least one letter that word does not have. Walk all `m`-bit candidates; for each survivor, write the abbreviation (flush a run length when you keep a letter or finish) and keep the one with smallest abbreviation length.

Valid Word Abbreviation (408) only checks one pair. Generalized Abbreviation (320) lists every abbreviation of one word, with no dictionary. Unique Word Abbreviation (288) asks whether a dictionary already makes one abbreviation unique.

Do not return `5` for `apple` vs `blade` (it abbreviates both). Do not score `10` as two length units. Do not test dictionary words of a different length.

Time: O(n 2^m)  
Space: O(n)

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

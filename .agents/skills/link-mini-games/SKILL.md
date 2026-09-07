---
name: link-mini-games
description: >-
  Scans mini games missing Algo Guide or Step-by-step association links and
  writes related_guide, related_session, and related_game when those artifacts
  already exist. Use after creating a mini game, when companion chrome cannot
  open a mini game from a guide or session, or when the user asks to update
  mini-game association links.
---

# Link mini games to Algo Guides and Step-by-step

Do not create guides, sessions, or games. Only write companion keys on existing `meta.php` files.

## When to run

- As part of harness creating a mini game under `content/games/`
- When a mini game is missing **Algo Guide** or **Step-by-step** chrome
- When companion keys on a matching Algo Guide or Step-by-step are missing `related_game`

## Do this

From the repo root:

```bash
php .agents/skills/link-mini-games/scripts/link.php
```

The script:

1. Lists every `content/games/{slug}/`
2. Keeps games that do not already have **both** a valid `related_guide` (algo guide on disk) **and** a valid `related_session` (step-by-step on disk), **or** whose matching guide/session is missing `related_game`
3. Resolves a match with `related_*` if valid, else same folder slug, else the same `leetcode` integer
4. If an Algo Guide exists, sets `'related_guide'` on the game and `'related_game'` on that guide
5. If a Step-by-step exists, sets `'related_session'` on the game and `'related_game'` on that session
6. Leaves a side unset when that artifact does not exist
7. Prints JSON: `linked`, `unchanged`, `unmatched`

Do not invent slugs. Do not overwrite a valid `related_game` that already points at a different existing game.

## After the script

Report which games gained which keys. If `unmatched` is non-empty, those games have no Algo Guide and/or no Step-by-step on disk — do not author them in this skill.

## Keys

| File | Key | Points at |
|------|-----|-----------|
| `content/games/{game}/meta.php` | `related_guide` | `content/guides/{slug}/` with `kind => 'algo'` |
| `content/games/{game}/meta.php` | `related_session` | `content/coaching/{slug}/` |
| `content/guides/{slug}/meta.php` | `related_game` | the game slug |
| `content/coaching/{slug}/meta.php` | `related_game` | the game slug |

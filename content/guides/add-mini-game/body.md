When a theory or LeetCode pattern still feels abstract, stay in this repo and ask Cursor to build a **mini-game** that appears in the Mini games section.

Use the harness skill at `.agents/skills/harness`. Games live under `content/games/{slug}/` with `meta.php` + `index.html`.

## What you get

- A list card in Mini games
- A playable page loaded in the IDE iframe
- One focused mechanic (pointers, hash map “seen”, stack frames, etc.)

## Build a Cursor prompt

Fill the fields, preview the prompt, then copy it into Cursor (or Claude Code).

> [!ui-builder] Build
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches [INPUT_TOPIC]. Place it under content/games/[INPUT_SLUG]. Follow the meta.php + index.html contract, and use .agents/skills/game-development-sickn33 for web/2d craft if needed.

## Prefer a coaching walkthrough instead?

Same idea — deterministic branching under `content/coaching/{slug}/` with `meta.php` + `tree.php` (wrong path + `rewind_to`, plus a success leaf).

> [!ui-builder] Build
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a coaching session for [INPUT_TOPIC] under content/coaching/[INPUT_SLUG]/. Include branching choices, at least one wrong-path leaf with rewind_to, and a success leaf. Follow the tree.php contract so Step back works in the UI.

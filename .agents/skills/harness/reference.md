# Harness reference — contracts and prompts

## Directory layout

```
content/
  guides/{slug}/meta.php + body.md   # prefer body.md; legacy body.php still works
  games/{slug}/meta.php + index.html
  coaching/{slug}/meta.php + tree.php
```

Lists are built by scanning those directories for `meta.php` (`includes/content.php`).
Guide Markdown is rendered by `includes/guide_md.php` (including `[!ui-builder]` widgets).

## meta.php (all types)

```php
<?php
declare(strict_types=1);

return [
    'title' => 'Human title',
    'summary' => 'One sentence for the list card.',
    'topic' => 'LeetCode · Arrays', // or System Design / Algo · Complexity / Harness · Cursor
    // guides only:
    'kind' => 'algo', // 'algo' → Algo Guides nav | 'cursor' → Cursor AI Guides nav
    'tags' => ['arrays', 'O(n)'],
    // games only:
    // 'entry' => 'index.html',
];
```

## Guide body.md + `[!ui-builder]`

```markdown
Intro paragraph in Markdown.

## Section

- Bullet
- Another

> [!ui-builder] Build
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a mini-game
> that teaches [INPUT_TOPIC] under content/games/[INPUT_SLUG]/.
```

| Piece | Meaning |
|-------|---------|
| `[!ui-builder]` | Renders the AI prompt builder widget |
| Optional title after the tag | Shown as a small widget title (e.g. `Build`) |
| `INPUT_NAME: Label` | Text field; key must be `INPUT_[A-Z0-9_]+` |
| `PROMPT:` | Template lines that follow |
| `[INPUT_NAME]` in prompt | Replaced by field value, or `___` if empty |

Viewer: fill fields → live **Prompt preview** → **Copy prompt** → paste into Cursor / Claude Code / etc.

## tree.php node fields

| Field | Type | Notes |
|-------|------|-------|
| `message` | string | Shown in the coaching panel; use `\n` for line breaks |
| `outcome` | `continue` \| `wrong` \| `success` | Controls choices vs end state styling |
| `choices` | list of `{label, next}` | Required when `continue` with more steps |
| `rewind_to` | string node id | Required on `wrong` leaves |

History: each choice POSTs `from_node` onto a stack; **Step back** pops or jumps to `rewind_to` and truncates history before that node.

## Student prompt templates

Copy into guide `[!ui-builder]` PROMPT bodies or the hub. Always mention `.agents/skills/harness`.

### Create an Algo Guide

```
Use the harness skill at .agents/skills/harness to create an Algo Guide in this Algo Learning IDE app for [TOPIC / PROBLEM]. Put it under content/guides/[slug]/ set kind => 'algo' in meta.php; use body.md; include complexity notes and an [!ui-builder] or copyable prompt to create a related mini-game and/or coaching session.
```

### Create a Cursor AI Guide

```
Use the harness skill at .agents/skills/harness to create a Cursor AI Guide in this Algo Learning IDE app about [HARNESS / CURSOR USAGE]. Put it under content/guides/[slug]/ set kind => 'cursor' in meta.php; use body.md with [!ui-builder] so the student can fill variables and copy a prompt into Cursor.
```

### Create a mini-game

```
Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches [THEORY OR PROBLEM]. Place it under content/games/[slug]/ follow meta.php + index.html. Use .agents/skills/game-development-sickn33 for web/2d craft if needed.
```

### Create a coaching session

```
Use the harness skill at .agents/skills/harness to create a coaching session for [TOPIC / PROBLEM] under content/coaching/[slug]/. Include branching choices, at least one wrong-path leaf with rewind_to, and a success leaf. Follow the tree.php contract so Step back works.
```

## Sample artifacts (shipped)

| Type | Slug |
|------|------|
| Algo Guide (`kind: algo`, PHP body) | `two-sum` |
| Cursor AI Guide (`kind: cursor`, Markdown + ui-builder) | `add-mini-game` |
| Mini game | `two-sum-pointers` |
| Coaching | `two-sum` |

Use these as templates when authoring new content.

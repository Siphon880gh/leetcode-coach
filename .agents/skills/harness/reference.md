# Harness reference — contracts and prompts

## Directory layout

```
content/
  guides/{slug}/meta.php + body.php
  games/{slug}/meta.php + index.html
  coaching/{slug}/meta.php + tree.php
```

Lists are built by scanning those directories for `meta.php` (`includes/content.php`).

## meta.php (all types)

```php
<?php
declare(strict_types=1);

return [
    'title' => 'Human title',
    'summary' => 'One sentence for the list card.',
    'topic' => 'LeetCode · Arrays', // or System Design / Algo · Complexity
    'tags' => ['arrays', 'O(n)'],
    // games only:
    // 'entry' => 'index.html',
];
```

## tree.php node fields

| Field | Type | Notes |
|-------|------|-------|
| `message` | string | Shown in the coaching panel; use `\n` for line breaks |
| `outcome` | `continue` \| `wrong` \| `success` | Controls choices vs end state styling |
| `choices` | list of `{label, next}` | Required when `continue` with more steps |
| `rewind_to` | string node id | Required on `wrong` leaves |

History: each choice POSTs `from_node` onto a stack; **Step back** pops or jumps to `rewind_to` and truncates history before that node.

## Student prompt templates

Copy into guide bodies or the hub. Always mention `.agents/skills/harness`.

### Create a guide

```
Use the harness skill at .agents/skills/harness to create a Cursor AI Guide in this Algo Learning IDE app for [TOPIC / PROBLEM]. Put it under content/guides/[slug]/ include complexity notes and copyable prompts to create a related mini-game and coaching session.
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
| Guide | `two-sum` |
| Mini game | `two-sum-pointers` |
| Coaching | `two-sum` |

Use these as templates when authoring new content.

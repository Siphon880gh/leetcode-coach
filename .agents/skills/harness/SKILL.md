---
name: harness
description: >-
  Create Cursor AI Guides, mini games, and deterministic coaching sessions for
  Algo Learning IDE with UI. Use when the user wants a new guide, game, or
  coaching wizard under content/, or when prompting how to author study
  artifacts in this app. Guides use Markdown body.md and may include
  [!ui-builder] AI prompt builder widgets.
---

# Algo Learning IDE — Harness

This skill is **strictly** for Cursor creating these three artifacts inside this app:

1. **Cursor AI Guides**
2. **Mini games**
3. **Coaching sessions** (deterministic)

Do not use this skill for unrelated refactors, general coding, or game theory outside wiring into this IDE. For deep game craft (loop, art, web/2d), read and follow `.agents/skills/game-development-sickn33` (and its sub-skills); this harness owns **app wiring and content contracts** only.

## Product framing (verbatim)

This ui is an interactive extension of the cursor harness to guide you or teach you

The app is for a student or person studying system design, data structures, algorithms, and leetcode. When a theory or problem doesnt make sense, this visual ui guides user on how to prompt AI to create another game or coaching session inside this app.

## When to use

| User intent | Create |
|-------------|--------|
| Explain a theory/problem as a lesson with Cursor prompts | Cursor AI Guide under `content/guides/{slug}/` |
| Small interactive game to understand a theory or problem | Mini game under `content/games/{slug}/` |
| Wizard that branches on choices, wrong path + step back | Coaching session under `content/coaching/{slug}/` |

## When not to use

- Changing PHP layout/CSS unless required for a new artifact type
- Calling an LLM at coaching runtime (coaching is deterministic trees only)
- Inventing a parallel content format outside the contracts below

## Shared rules

- Slug: lowercase kebab-case, no spaces (`two-sum`, `rate-limiter-sd`)
- `meta.php` must `return [...]` an array
- After creating files, the item must appear via directory scan in the matching section list (no manual registry file)
- Include tags/topic that match System Design, Algo (O(N) space/time), or LeetCode (Arrays, etc.)
- In guides (and when helpful in game/coach intros), include a **copyable Cursor prompt** telling the student to use `.agents/skills/harness` to create another game or coaching session — prefer an `[!ui-builder]` widget when the student should fill in variables (topic, slug, etc.)

---

## 1. Cursor AI Guides

**Output**

```
content/guides/{slug}/
  meta.php
  body.md
```

Prefer `body.md` for all new guides. Legacy `body.php` still renders if `body.md` is absent; do not create new `body.php` guides.

**meta.php keys**

| Key | Required | Meaning |
|-----|----------|---------|
| `title` | yes | Display title |
| `summary` | yes | One-line list description |
| `topic` | yes | e.g. `LeetCode · Arrays`, `System Design`, `Algo · Complexity`, `Harness · Cursor` |
| `tags` | yes | string[] |

**body.md**

- Markdown fragments (not a full HTML document); title/summary come from `meta.php`
- Cover the idea, complexity (time/space) when relevant, and steps
- Use normal Markdown: headings (`#` / `##`), lists, `inline code`, `**bold**`, fenced code blocks
- End with (or include) copyable Cursor prompts via **`[!ui-builder]`** when the learner fills in variables; plain fenced prompts are OK only when there are no fields to fill

### AI prompt builder — `[!ui-builder]`

Use a Markdown blockquote callout. Each `INPUT_*` line becomes a labeled text field. Tokens `[INPUT_*]` in `PROMPT:` are replaced in the live preview (`___` when empty). The viewer shows **Copy prompt** plus “Then open in your favorite IDE…”.

```markdown
> [!ui-builder] Build
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches [INPUT_TOPIC]. Place it under content/games/[INPUT_SLUG]/ follow meta.php + index.html.
```

**Rules for `[!ui-builder]`**

- First line: `> [!ui-builder]` or `> [!ui-builder] Build` (optional title after the tag)
- Zero or more `> INPUT_NAME: Label shown above the field` — keys must match `INPUT_[A-Z0-9_]+`
- Then `> PROMPT:` followed by prompt lines (each still prefixed with `>`)
- Inside the prompt, reference fields as `[INPUT_NAME]` (brackets required)
- Multiple builders are allowed in one guide
- Keep every line of the block as a blockquote (`>`)

**Sample guide:** `content/guides/add-mini-game/` (two builders: mini-game + coaching)

**UI:** appears in `guides/index.php`, viewed via `guides/view.php?id={slug}` (`body.md` via `includes/guide_md.php`)

---

## 2. Mini games

**Output**

```
content/games/{slug}/
  meta.php
  index.html   # default entry (or path set in meta.entry)
```

**meta.php keys**

| Key | Required | Meaning |
|-----|----------|---------|
| `title` | yes | Display title |
| `summary` | yes | One-line list description |
| `topic` | yes | Topic label |
| `tags` | yes | string[] |
| `entry` | no | Default `index.html` |

**index.html**

- Self-contained playable page (CSS/JS inline or relative assets in the same folder)
- Teach one idea (pointer motion, hash map “seen”, recursion stack, etc.)
- Keep MVP games small; for richer web/2d work, apply `game-development-sickn33` then still wire `meta.php` + entry here

**UI:** `games/index.php`, play via `games/play.php?id={slug}` (iframe to the entry file)

---

## 3. Coaching sessions (deterministic)

**Output**

```
content/coaching/{slug}/
  meta.php
  tree.php
```

**meta.php keys** — same shape as guides (`title`, `summary`, `topic`, `tags`)

**tree.php**

```php
return [
  'start' => 'start',
  'nodes' => [
    'start' => [
      'message' => '...',
      'outcome' => 'continue', // continue | wrong | success
      'choices' => [
        ['label' => '...', 'next' => 'node_id'],
      ],
      // on outcome === 'wrong':
      // 'rewind_to' => 'node_id',  // tell user to step back to when...
    ],
  ],
];
```

**Rules**

- Every `choices[].next` must reference an existing node id
- At least one `outcome => 'wrong'` leaf with `rewind_to` set to an earlier decision node
- Prefer a `success` leaf for a correct finish
- Wrong leaf message must tell the learner they are wrong and when to step back
- No randomness, no live AI — fixed graph only

**UI:** `coaching/session.php?id={slug}` — history stack + Step back (pop or jump to `rewind_to`)

---

## Workflow checklist

1. Confirm which artifact (guide / game / coaching)
2. Pick slug and topic tags
3. Write files under the correct `content/.../{slug}/` tree
4. For guides: write `body.md`; add `[!ui-builder]` when the student should fill variables before copying a Cursor prompt
5. Match contracts exactly so list/view/play/session pick them up
6. For games needing real game design, open `game-development-sickn33` first, then wire harness meta/entry
7. Smoke-check: open the section list page and open the new item

See [reference.md](reference.md) for schemas, ui-builder syntax, and student-facing prompt templates.

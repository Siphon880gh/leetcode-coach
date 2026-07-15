---
name: harness
description: >-
  Create Cursor AI Guides, mini games, and deterministic coaching sessions for
  Algo Learning IDE with UI. Use when the user wants a new guide, game, or
  coaching wizard under content/, or when prompting how to author study
  artifacts in this app.
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
- In guides (and when helpful in game/coach intros), include a **copyable Cursor prompt** telling the student to use `.agents/skills/harness` to create another game or coaching session

---

## 1. Cursor AI Guides

**Output**

```
content/guides/{slug}/
  meta.php
  body.php
```

**meta.php keys**

| Key | Required | Meaning |
|-----|----------|---------|
| `title` | yes | Display title |
| `summary` | yes | One-line list description |
| `topic` | yes | e.g. `LeetCode · Arrays`, `System Design`, `Algo · Complexity` |
| `tags` | yes | string[] |

**body.php**

- Outputs HTML fragments (not a full document); it runs inside the guide article
- Cover the idea, complexity (time/space) when relevant, and steps
- End with a “Prompt Cursor…” section and at least one `<pre id="...">` prompt + button `data-copy-target="#..."` for harness creation of a related game and/or coaching session

**UI:** appears in `guides/index.php`, viewed via `guides/view.php?id={slug}`

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
4. Match contracts exactly so list/view/play/session pick them up
5. For games needing real game design, open `game-development-sickn33` first, then wire harness meta/entry
6. Smoke-check: open the section list page and open the new item

See [reference.md](reference.md) for schemas and student-facing prompt templates.

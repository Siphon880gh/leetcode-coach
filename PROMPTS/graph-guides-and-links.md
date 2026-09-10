# Graph: Algo Guides + Step-by-step, keep counts within 20, always pair

One graph tick = **one author child** (either algo-guides or step-by-step) **then** the links half. Read this file and the child trackers every tick.

## Invoke

```
/loop Follow PROMPTS/graph-guides-and-links.md. Each tick: count algo guides vs step-by-step. If one side is more than 20 ahead, author one companion on the lagging side for a slug that already has the leading side. Otherwise one algo-guides problem. Then one pairable guide↔step link. Update the child trackers you touched before you finish the tick.
```

## Why this graph

[`loop-guide-step-links.md`](loop-guide-step-links.md) walking the **union** and skipping `"no_pair"` would burn slugs that exist on only one side. The author loops walk the same `context/` order, so one side can pull ahead.

This graph:

- Authors **Algo Guides** while they are not more than 20 ahead of Step-by-step
- When Algo Guides are **more than 20** ahead, authors a **Step-by-step** for a slug that already has an Algo Guide (companion keys both ways)
- When Step-by-step is **more than 20** ahead, authors an **Algo Guide** for a slug that already has a session (companion keys both ways)
- When authoring either side, scans existing mini games (same slug, related keys, or same `leetcode`) and writes `related_game` so the new page can link to the game
- Then links one pairable intersection slug

## Difficulty (author halves)

When an author half creates a numbered LeetCode Algo Guide or Step-by-step, `meta.php` must set `'leetcode'` and `'difficulty'` (`Easy` | `Med` | `Hard`) as in the child prompt. Look up from `context-leetcode-urls/data-difficulty.json` (do not `Read()` the file whole). Do not invent. Never put Easy / Med / Hard in `title`. Mini games created by `loop-mini-games.md` use the same keys.

## Counts (every tick)

Ignore `kind => 'cursor'` guides (for example `add-mini-game`). Missing `kind` counts as algo.

| Symbol | Meaning |
|--------|---------|
| `G` | Number of `content/guides/{slug}/` with `kind => 'algo'` |
| `S` | Number of `content/coaching/{slug}/` |
| Ahead | `G > S + 20` → guides lead; `S > G + 20` → sessions lead |

`20` is exclusive: a lead of 20 stays on the default (algo-guides) half. A lead of 21 switches to the lagging author.

## Nodes

```
count G vs S
        |
        +-- G > S + 20 --> loop-step-by-step.md  (slug must already have an algo guide)
        |
        +-- S > G + 20 --> loop-algo-guides.md   (slug must already have a session)
        |
        +-- else       --> loop-algo-guides.md   (context next)
        |
        v
loop-guide-step-links.md  -->  related_session / related_guide
        |                      (intersection only while authors still run)
        v
repeat
```

## Each graph tick

1. If both author trackers are `exhausted` **and** there is no unlinked pair (see **Links half**), stop the graph. Do not arm another wake.
2. Run **Once (if missing)** from [`loop-guide-step-links.md`](loop-guide-step-links.md) (chrome, harness docs, companion keys on author loops). Then continue.
3. Compute `G` and `S`. Choose **exactly one** author half:
   - **Session catch-up** when `G > S + 20`. Follow [`loop-step-by-step.md`](loop-step-by-step.md) for its `next` problem. That slug **must** already have `content/guides/{slug}/` with `kind => 'algo'`. Create `content/coaching/{slug}/` (or skip `slug_exists`). Set `'related_guide'` on the session and `'related_session'` on the guide. Scan `content/games/` for a matching mini game (same slug, `related_session`/`related_guide` pointing here, or same `leetcode`); if found, set `'related_game'` on the new session and `'related_session'` on that game. If `next` has no algo guide, append step-by-step `skipped` with `"reason": "no_guide"` and advance `next` — do not create an unpaired session. Update [`loop-step-by-step.track.json`](loop-step-by-step.track.json). Do **not** run the algo-guides half.
   - **Guide catch-up** when `S > G + 20`. Follow [`loop-algo-guides.md`](loop-algo-guides.md) for its `next` problem. That slug **must** already have `content/coaching/{slug}/`. Create the algo guide (or skip `slug_exists`). Set both companion keys. Scan `content/games/` the same way; if a matching game exists, set `'related_game'` on the new guide and `'related_guide'` on that game. If `next` has no session, append algo-guides `skipped` with `"reason": "no_session"` and advance `next` — do not create an unpaired guide. Update [`loop-algo-guides.track.json`](loop-algo-guides.track.json). Do **not** run the step-by-step half.
   - **Default** otherwise. Follow [`loop-algo-guides.md`](loop-algo-guides.md) for exactly one `next` problem. If a session already exists for that slug, set both companion keys. If a matching mini game already exists, set `'related_game'` on the guide and `'related_guide'` on that game. If this loop is already exhausted, skip this half. Update [`loop-algo-guides.track.json`](loop-algo-guides.track.json). Do **not** run the step-by-step half.
4. **Links half.** Follow [`loop-guide-step-links.md`](loop-guide-step-links.md) with the **Catch-up** queue (intersection), not the union/`no_pair` walk:
   - Pairable = algo-guide slugs ∩ coaching slugs, `LC_ALL=C` sort, not yet in `completed` / `already_linked`.
   - Prefer the slug just processed in the author half if it is pairable.
   - Otherwise take the first remaining pairable slug.
   - If none: do **not** append `"no_pair"`, do **not** set links `exhausted`. Set links `next` to `null`. Stop the links half.
   - If one: write both companion keys (or record `already_linked`), advance links `next` to the next pairable slug or `null`, write [`loop-guide-step-links.track.json`](loop-guide-step-links.track.json).
5. Stop. Do not start a second author problem or a second link slug in this graph tick.

## Exhausted

| Child | Exhausted when |
|-------|----------------|
| Algo-guides | Its tracker `exhausted` is `true` (context queue finished) |
| Step-by-step | Its tracker `exhausted` is `true` |
| Links | Both author loops are exhausted **and** no unlinked pair remains. Then leftover coaching-only / guide-only slugs may be recorded as `"no_pair"` and links `exhausted` set `true` |
| Graph | Both author children exhausted **and** links exhausted |

While an author loop is still running, links stay `exhausted: false` even if the current intersection is fully linked — more pairs will appear.

## Do not

- Run both `loop-algo-guides.md` and `loop-step-by-step.md` in the same graph tick
- Author a Step-by-step whose slug has no Algo Guide, or an Algo Guide whose slug has no session, during a **catch-up** half
- Drain [`loop-guide-step-links.md`](loop-guide-step-links.md) standalone with the union/`no_pair` walk until this graph (or both author loops) is done
- Process more than one context problem or more than one pair per graph tick
- Commit unless the user asks

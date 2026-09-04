# Loop: Algo Guide ↔ Step-by-step links

One tick = one slug. Read this file and [`loop-guide-step-links.track.json`](loop-guide-step-links.track.json) on every tick.

## Invoke

```
/loop Follow PROMPTS/loop-guide-step-links.md. One slug per tick. Update PROMPTS/loop-guide-step-links.track.json before you finish the tick.
```

## Goal

Associate an existing **Algo Guide** (`content/guides/{slug}/`, `kind => 'algo'`) with an existing **Step-by-step** session (`content/coaching/{slug}/`) when they share the same slug. Write companion keys both ways and show a chrome link on each page to the other.

Do **not** walk `context/`. Do **not** create guides, sessions, or games. `PROMPTS/loop-algo-guides.md` and `PROMPTS/loop-step-by-step.md` author those.

## Pairing

Same folder slug:

- `content/guides/{slug}/` with `kind => 'algo'`
- `content/coaching/{slug}/`

Ignore `kind => 'cursor'` guides. Do not invent a different slug on either side.

## Link contract

Both directions, or the tick is not done:

| Side | `meta.php` key | Chrome |
|------|----------------|--------|
| Algo Guide | `'related_session' => '{slug}'` | **Step-by-step** → `coaching/session.php?id={slug}` |
| Step-by-step | `'related_guide' => '{slug}'` | **Algo Guide** → `guides/view.php?id={slug}` |

Keep every other `meta.php` field as-is. Do not rewrite `body.md`, `body.php`, or `tree.php`.

Chrome lives in the page-head on `guides/view.php` and `coaching/session.php`. Render the link only when the key is set **and** the other artifact is on disk. Do not add routes.

## Once (if missing)

Before processing `next` on a tick, if the chrome (or the harness docs) are still missing, do this **once** in that tick, then continue with the slug:

1. Page-head companion links on `guides/view.php` and `coaching/session.php` as in **Link contract**.
2. Document optional `related_session` (guides) and `related_guide` (coaching) in `.agents/skills/harness/SKILL.md` and `.agents/skills/harness/reference.md`.
3. In `PROMPTS/loop-algo-guides.md` and `PROMPTS/loop-step-by-step.md`: when creating an artifact, if the same slug already exists on the other side, set the companion key. Those loops must not backfill every existing pair.

Skip this block on later ticks if it is already in place.

## Catch-up (author loops still running)

If [`loop-algo-guides.track.json`](loop-algo-guides.track.json) or [`loop-step-by-step.track.json`](loop-step-by-step.track.json) has `"exhausted": false`, do **not** walk the union and skip `"no_pair"`. Prefer [`graph-guides-and-links.md`](graph-guides-and-links.md).

Catch-up queue:

1. Pairable = algo-guide slugs ∩ coaching slugs, `LC_ALL=C` sort.
2. Take the first pairable slug that is not in `completed` and not `already_linked`. Prefer the slug just authored in the same graph tick if it is pairable.
3. If none: set `next` to `null`, leave `exhausted` false, stop the tick. Do not append `"no_pair"`.
4. If both keys already point at this slug and the chrome would work: append to `skipped` with `"reason": "already_linked"` and go to **Advance `next`**.
5. If both sides exist and keys are missing: write the two `meta.php` keys. Append to `completed`.
6. After this slug is in `completed` or `skipped`, set `next` to the next remaining pairable slug, or `null` if none.

Set `"exhausted": true` on this tracker only when **both** author loops are exhausted **and** no unlinked pair remains. Then leftover union-only slugs may be recorded as `"no_pair"`.

## Each tick

1. Read [`loop-guide-step-links.track.json`](loop-guide-step-links.track.json). If `exhausted` is `true`, stop the loop and say the queue is finished.
2. Run **Once (if missing)** when needed.
3. If an author loop is still running, follow **Catch-up** and stop after one slug (or idle). Skip the union walk below.
4. Rebuild the queue: union of algo-guide slugs and coaching slugs, `LC_ALL=C` sort. Rescan every tick; the set grows as the other loops add content.
5. Take `next.slug`. If `next` is `null` or that slug is missing from the current union, advance `next`.
6. If both sides exist: write the two `meta.php` keys. Append to `completed`.
7. If only one side exists: do **not** create the missing artifact. Append to `skipped` with `"reason": "no_pair"` and advance `next`.
8. If both keys already point at this slug and the chrome would work: append to `skipped` with `"reason": "already_linked"` and advance `next`.
9. Advance the cursor (below) and write the tracking JSON (pretty-printed, 2-space indent).
10. Stop. Do not start a second slug in the same tick.

## Advance `next`

After this tick’s slug is in `completed` or `skipped`:

**Catch-up:** rebuild the pairable intersection. Take the first remaining unlinked pairable slug **strictly after** the slug you just processed, or `null` if none. Do not set `exhausted`.

**Union walk** (both author loops exhausted):

1. Rebuild the union with `LC_ALL=C` sort.
2. Take the first slug **strictly after** the slug you just processed.
3. If none remain, set `exhausted` to `true` and `next` to `null`.

Keep `cursor.last_slug` equal to the slug you just processed.

`completed` / `skipped` entries:

```json
{
  "slug": "two-sum",
  "guide": true,
  "session": true,
  "reason": "no_pair"
}
```

(`reason` only on `skipped`.)

## Do not

- Create `content/guides/`, `content/coaching/`, or `content/games/` folders
- Overwrite teaching content (`body.md`, `body.php`, `tree.php`, titles, summaries)
- Pair mini games
- Pair `kind => 'cursor'` guides
- Walk `context/`
- Commit unless the user asks
- Add PHP routes
- Process more than one slug per tick

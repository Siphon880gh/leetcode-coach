# Loop prompts

Cursor `/loop` jobs that walk a queue one tick at a time. Each prompt has a matching `.track.json` with `next`, `completed`, `skipped`, and `exhausted`. Read both files every tick. Update the tracker before the tick finishes.

Invoke from the repo root. Copy the **Invoke** block inside each prompt.

## Author from `context/`

These three walk the cloned libraries under `context/` (alphabetical repo order). They **create** artifacts. If the same slug already exists on the other side, they set that one pair’s companion keys. They do not backfill every pair.

| Prompt | Writes | Notes |
|--------|--------|--------|
| [`loop-step-by-step.md`](loop-step-by-step.md) | `content/coaching/{slug}/` | Deterministic choice trees |
| [`loop-algo-guides.md`](loop-algo-guides.md) | `content/guides/{slug}/` (`kind => 'algo'`) | Lessons + `[!ui-builder]` |
| [`loop-mini-games.md`](loop-mini-games.md) | `content/games/{slug}/` | Only when the problem has one interactive mechanic; otherwise skip |

A loop is **drained** when its tracker has `"exhausted": true` (queue finished, `next` is `null`).

Mini games can run whenever. It does not feed the link loop.

## Catch-up (step-by-step paused)

When step-by-step is paused and Algo Guides are behind, do **not** drain [`loop-guide-step-links.md`](loop-guide-step-links.md) standalone. Its union/`no_pair` walk would skip coaching slugs that do not have a guide yet.

Use [`graph-guides-and-links.md`](graph-guides-and-links.md): one graph tick runs one algo-guides problem, then one **pairable** guide↔session link (intersection only).

## Link after both author loops are drained

[`loop-guide-step-links.md`](loop-guide-step-links.md) does **not** create guides or sessions. It pairs an Algo Guide and a Step-by-step that already share a slug, writes `related_session` / `related_guide`, and shows a chrome link each way.

The standalone union/`no_pair` walk is for after both author loops are exhausted:

1. [`loop-step-by-step.md`](loop-step-by-step.md)
2. [`loop-algo-guides.md`](loop-algo-guides.md)

Until then, use [`graph-guides-and-links.md`](graph-guides-and-links.md) (or the Catch-up queue inside the link prompt).

## Trackers

| Prompt | Tracker |
|--------|---------|
| `graph-guides-and-links.md` | Child trackers below (no separate graph tracker) |
| `loop-step-by-step.md` | [`loop-step-by-step.track.json`](loop-step-by-step.track.json) |
| `loop-algo-guides.md` | [`loop-algo-guides.track.json`](loop-algo-guides.track.json) |
| `loop-mini-games.md` | [`loop-mini-games.track.json`](loop-mini-games.track.json) |
| `loop-guide-step-links.md` | [`loop-guide-step-links.track.json`](loop-guide-step-links.track.json) |

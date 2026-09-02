# Loop prompts

Cursor `/loop` jobs that walk a queue one tick at a time. Each prompt has a matching `.track.json` with `next`, `completed`, `skipped`, and `exhausted`. Read both files every tick. Update the tracker before the tick finishes.

Invoke from the repo root. Copy the **Invoke** block inside each prompt.

## Author from `context/`

These three walk the cloned libraries under `context/` (alphabetical repo order). They **create** artifacts. They do not link them.

| Prompt | Writes | Notes |
|--------|--------|--------|
| [`loop-step-by-step.md`](loop-step-by-step.md) | `content/coaching/{slug}/` | Deterministic choice trees |
| [`loop-algo-guides.md`](loop-algo-guides.md) | `content/guides/{slug}/` (`kind => 'algo'`) | Lessons + `[!ui-builder]` |
| [`loop-mini-games.md`](loop-mini-games.md) | `content/games/{slug}/` | Only when the problem has one interactive mechanic; otherwise skip |

A loop is **drained** when its tracker has `"exhausted": true` (queue finished, `next` is `null`).

Mini games can run whenever. It does not feed the link loop.

## Link after both author loops are drained

[`loop-guide-step-links.md`](loop-guide-step-links.md) does **not** create guides or sessions. It pairs an Algo Guide and a Step-by-step that already share a slug, writes `related_session` / `related_guide`, and shows a chrome link each way.

**Run it only after you have finished draining both:**

1. [`loop-step-by-step.md`](loop-step-by-step.md)
2. [`loop-algo-guides.md`](loop-algo-guides.md)

If you run the link loop earlier, unmatched slugs skip with `"reason": "no_pair"` and you will miss pairs that the author loops have not written yet. Drain those two first, then start [`loop-guide-step-links.md`](loop-guide-step-links.md).

## Trackers

| Prompt | Tracker |
|--------|---------|
| `loop-step-by-step.md` | [`loop-step-by-step.track.json`](loop-step-by-step.track.json) |
| `loop-algo-guides.md` | [`loop-algo-guides.track.json`](loop-algo-guides.track.json) |
| `loop-mini-games.md` | [`loop-mini-games.track.json`](loop-mini-games.track.json) |
| `loop-guide-step-links.md` | [`loop-guide-step-links.track.json`](loop-guide-step-links.track.json) |

# Graph: catch-up Algo Guides + Guide ↔ Step-by-step links

One graph tick = **two child ticks** (algo-guides, then links). Read this file and both child trackers every tick.

Do **not** run [`loop-step-by-step.md`](loop-step-by-step.md). That drain is paused.

## Invoke

```
/loop Follow PROMPTS/graph-guides-and-links.md. Each tick: one algo-guides problem, then one pairable guide↔step link. Do not run loop-step-by-step.md. Update both child trackers before you finish the tick.
```

## Why this graph

[`loop-guide-step-links.md`](loop-guide-step-links.md) walking the **union** and skipping `"no_pair"` would burn coaching slugs that do not have an Algo Guide yet. Step-by-step is ahead (~169 sessions). Algo Guides has `two-sum` only.

This graph drains both children **together**: create (or skip) one guide, then link one slug that already has both sides.

## Nodes

```
pause loop-step-by-step
        |
        v
loop-algo-guides.md     -->  content/guides/{slug}/
        |
        |  same tick, after the guide half
        v
loop-guide-step-links.md  -->  related_session / related_guide
        |                      (intersection only while catching up)
        v
repeat until both child trackers are exhausted
```

## Each graph tick

1. If [`loop-algo-guides.track.json`](loop-algo-guides.track.json) `exhausted` is `true` **and** there is no unlinked pair (see **Links half**), stop the graph. Do not arm another wake.
2. Run **Once (if missing)** from [`loop-guide-step-links.md`](loop-guide-step-links.md) (chrome, harness docs, companion keys on author loops). Then continue.
3. **Algo-guides half.** Follow [`loop-algo-guides.md`](loop-algo-guides.md) for exactly one `next` problem. Update [`loop-algo-guides.track.json`](loop-algo-guides.track.json). If that loop is already exhausted, skip this half.
4. **Links half.** Follow [`loop-guide-step-links.md`](loop-guide-step-links.md) with the **Catch-up** queue (intersection), not the union/`no_pair` walk:
   - Pairable = algo-guide slugs ∩ coaching slugs, `LC_ALL=C` sort, not yet in `completed` / `already_linked`.
   - Prefer the slug just processed in the algo-guides half if it is pairable.
   - Otherwise take the first remaining pairable slug.
   - If none: do **not** append `"no_pair"`, do **not** set links `exhausted`. Set links `next` to `null`. Stop the links half.
   - If one: write both companion keys (or record `already_linked`), advance links `next` to the next pairable slug or `null`, write [`loop-guide-step-links.track.json`](loop-guide-step-links.track.json).
5. Stop. Do not start a second algo-guides problem or a second link slug in this graph tick.

## Exhausted

| Child | Exhausted when |
|-------|----------------|
| Algo-guides | Its tracker `exhausted` is `true` (context queue finished) |
| Links | Algo-guides is exhausted **and** no unlinked pair remains. Then leftover coaching-only / guide-only slugs may be recorded as `"no_pair"` and links `exhausted` set `true` |
| Graph | Both children exhausted |

While algo-guides is still running, links stay `exhausted: false` even if the current intersection is fully linked — more pairs will appear.

## Do not

- Arm or continue [`loop-step-by-step.md`](loop-step-by-step.md)
- Drain [`loop-guide-step-links.md`](loop-guide-step-links.md) standalone with the union/`no_pair` walk until this graph (or both author loops) is done
- Process more than one context problem or more than one pair per graph tick
- Commit unless the user asks

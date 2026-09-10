`Trips` (`id`, `client_id`, `driver_id`, `city_id`, `status`, `request_at`) and `Users` (`users_id`, `banned`, `role`). Status is `completed`, `cancelled_by_driver`, or `cancelled_by_client`. Cancellation rate = cancelled trips / all trips that day, **only** when both client and driver have `banned = 'No'`. Days `2013-10-01` through `2013-10-03` that have at least one such trip. Round to two decimals. Sample: `0.33`, `0.00`, `0.50`.

## Join Users twice; AVG of not-completed

Customers Who Never Order is an anti-join. Rising Temperature self-joins dates. Duplicate Emails groups one table. Here each trip has **two** users that must both be unbanned.

Join `Trips t` to `Users u1` on `t.client_id = u1.users_id AND u1.banned = 'No'`, and to `Users u2` on `t.driver_id = u2.users_id AND u2.banned = 'No'`. Inner joins drop a trip if either side is banned. `WHERE request_at BETWEEN '2013-10-01' AND '2013-10-03'`. `GROUP BY request_at`. `ROUND(AVG(status != 'completed'), 2)` is the rate: the boolean is 1 for either cancel status and 0 for completed. Alias `Day` and `Cancellation Rate`. Days with no remaining trips disappear from the group (that is “at least one trip”). Do not filter only the client. Do not count `cancelled_by_client` and skip driver cancels. Do not use `COUNT(1)` of cancels without dividing by the day’s total.

**Time:** O(t + u) with hash joins  
**Space:** O(t)

> [!ui-builder] Mini game
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches [INPUT_TOPIC]. Place it under content/games/[INPUT_SLUG]/. Follow meta.php + index.html. Use .agents/skills/game-development-sickn33 for web/2d craft if needed.

> [!ui-builder] Step-by-step
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a step-by-step session for [INPUT_TOPIC] under content/coaching/[INPUT_SLUG]/. Include branching choices with clear labels, at least one wrong-path leaf with rewind_to, and a success leaf. Follow the tree.php contract so Step back and the Path visualizer work.

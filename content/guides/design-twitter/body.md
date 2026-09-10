Simplified Twitter: `postTweet(userId, tweetId)`, `follow` / `unfollow`, and `getNewsFeed(userId)` returning up to 10 tweet ids from newest to oldest. The feed is tweets by the user or anyone they follow. Example: user 1 posts 5, feed `[5]`; follows 2; 2 posts 6; feed `[6, 5]`; unfollow 2; feed `[5]` again. Tweet ids are unique. At most about 3×10^4 mixed calls. A user cannot follow themself.

## Lists plus a clock; k-way newest 10

Keep `user → list of tweet ids` (append on post), `user → set of followees`, and a global `time` that maps each tweet id to when it was posted.

For the feed, take the user plus their followees. From each of those lists, only the last 10 ids matter (older ones cannot enter a top-10). Merge those candidates by decreasing time (heap / `nlargest`). Do not omit the user’s own tweets. Do not sort the entire history if each person has many posts. Unfollow is a no-op when the followee was not followed.

Time: O(F) to gather, with F ≤ 10 × (1 + followees), then O(F log 10) to pick 10  
Space: O(tweets + follows)

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

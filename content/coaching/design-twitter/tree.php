<?php
declare(strict_types=1);

/**
 * Step-by-step tree contract:
 * - start: node id
 * - nodes[id]: message, outcome (continue|wrong|success), choices[{label, next}], optional rewind_to on wrong
 */
return [
    'start' => 'start',
    'nodes' => [
        'start' => [
            'message' => "Problem: postTweet, follow, unfollow, getNewsFeed of up to 10 tweet ids, newest first. Feed = self plus followees. User 1 posts 5 → [5]. Follows 2; 2 posts 6 → [6, 5]. Unfollow 2 → [5]. About 3×10^4 mixed calls. A user does not follow themself.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep one global list of every tweet and sort it on each getNewsFeed', 'next' => 'wrong_all'],
                ['label' => 'Per-user tweet lists, follow sets, and a global clock on each tweet id', 'next' => 'store'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong here. Sorting the entire history on every feed call wastes work when one person has many old posts.\nStep back to when you sorted every tweet.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'store' => [
            'message' => "On post, bump time, append the tweet id to that user, record time[id]. For the feed, take the user plus their followees. From each list, only the last 10 ids can enter a top-10. Merge those candidates by decreasing time (heap or nlargest).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Feed is only followees, so you omit the user’s own tweets unless they follow themself', 'next' => 'wrong_self'],
                ['label' => 'Always add the user to the candidate set. Self is in the feed without a self-follow', 'next' => 'unfollow'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong. The feed must include the user’s own posts. They are not allowed to follow themself, so you must add userId yourself.\nStep back to when you dropped self.",
            'outcome' => 'wrong',
            'rewind_to' => 'store',
            'choices' => [],
        ],
        'unfollow' => [
            'message' => "Unfollow of someone you did not follow is a no-op (do not crash). Follow of self is invalid. Tweet ids are unique, so the clock map is enough to order them.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Last 10 per relevant user, merge by time. Include self. Unfollow missing is a no-op', 'next' => 'success'],
                ['label' => 'Remove the followee from the set even when they were never followed, or throw if missing', 'next' => 'wrong_unf'],
            ],
        ],
        'wrong_unf' => [
            'message' => "You are wrong. Invalid unfollow is a no-op. Do not assume the followee is in the set.\nStep back to when you crashed or removed a missing followee.",
            'outcome' => 'wrong',
            'rewind_to' => 'unfollow',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Per-user lists, follow sets, global clock. Merge the last 10 tweets from self plus followees. 1 posts 5, 2 posts 6 after a follow → [6, 5]. Not a full-history sort.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];

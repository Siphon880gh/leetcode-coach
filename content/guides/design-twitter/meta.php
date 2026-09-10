<?php
declare(strict_types=1);

return [
    'title' => 'Design Twitter: timestamped tweets, heap the last 10',
    'leetcode' => 355,
    'summary' => 'postTweet, follow/unfollow, getNewsFeed of the 10 newest tweets from self plus followees. Store each user’s tweet ids, a follow set, and a global clock. Merge the last 10 of each relevant user by time. Self is always in the feed. Unfollow of a non-followee is a no-op.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-map', 'heap', 'leetcode'],
    'related_session' => 'design-twitter',
];

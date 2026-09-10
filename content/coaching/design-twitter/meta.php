<?php
declare(strict_types=1);

return [
    'title' => 'Design Twitter: timestamped tweets, heap the last 10',
    'leetcode' => 355,
    'summary' => 'Walk a deterministic path: post with a global clock, follow sets, getNewsFeed of the 10 newest from self plus followees. Merge only the last 10 per user. User 1 posts 5, follows 2, 2 posts 6 → [6, 5]; unfollow 2 → [5]. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'hash-map', 'heap', 'step-by-step'],
    'related_guide' => 'design-twitter',
];

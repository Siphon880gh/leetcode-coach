<?php
declare(strict_types=1);

return [
    'title' => 'Increasing Triplet Subsequence: smallest, then a mid, then a larger',
    'leetcode' => 334,
    'summary' => 'True iff some i < j < k with strictly increasing values (not a subarray). Track mi and a mid that already has a smaller before it; a later num > mid is the third. Equals do not count. [2,1,5,0,4,6] → true. n up to 5e5 so not 300’s O(n²).',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'kind' => 'algo',
    'tags' => ['greedy', 'arrays', 'longest-increasing-subsequence', 'leetcode'],
    'related_session' => 'increasing-triplet-subsequence',
];

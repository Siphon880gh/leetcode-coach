<?php
declare(strict_types=1);

return [
    'title' => 'Increasing Triplet Subsequence: smallest, then a mid, then a larger',
    'leetcode' => 334,
    'summary' => 'Walk a deterministic path: true iff some i < j < k with strictly increasing values (not a subarray). Track mi and a mid that already has a smaller before it; a later num > mid is the third. Equals do not count. [2,1,5,0,4,6] → true. n up to 5e5 so not 300’s O(n²). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'tags' => ['greedy', 'arrays', 'longest-increasing-subsequence', 'step-by-step'],
    'related_guide' => 'increasing-triplet-subsequence',
];

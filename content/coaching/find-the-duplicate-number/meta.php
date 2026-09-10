<?php
declare(strict_types=1);

return [
    'title' => 'Find the Duplicate Number: pigeonhole count, or Floyd entrance',
    'leetcode' => 287,
    'summary' => 'Walk a deterministic path: n+1 values in 1..n, one duplicate, no extra array, do not mutate. Binary search on x: if more than x numbers are ≤ x, the duplicate is in 1..x. Floyd: nums[i] as next; cycle entrance is the duplicate. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'tags' => ['arrays', 'binary-search', 'floyd', 'step-by-step'],
    'related_guide' => 'find-the-duplicate-number',
];

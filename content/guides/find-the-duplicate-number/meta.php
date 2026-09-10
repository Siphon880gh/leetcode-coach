<?php
declare(strict_types=1);

return [
    'title' => 'Find the Duplicate Number: pigeonhole count, or Floyd entrance',
    'leetcode' => 287,
    'summary' => 'n+1 values in 1..n, one duplicate, no extra array, do not mutate. Binary search on x: if more than x numbers are ≤ x, the duplicate is in 1..x. Floyd: treat nums[i] as next; the cycle entrance is the duplicate.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'binary-search', 'floyd', 'leetcode'],
    'related_session' => 'find-the-duplicate-number',
];

<?php
declare(strict_types=1);

return [
    'title' => 'First Bad Version: binary search the first true isBadVersion',
    'leetcode' => 278,
    'summary' => 'Walk a deterministic path: versions 1..n; once bad, all later are bad. If mid is bad, first bad is in [l, mid]; else [mid+1, r]. Return l. Avoid overflow mid. Do not scan linearly. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'tags' => ['binary-search', 'interactive', 'step-by-step'],
    'related_guide' => 'first-bad-version',
];

<?php
declare(strict_types=1);

return [
    'title' => 'First Bad Version: binary search the first true isBadVersion',
    'leetcode' => 278,
    'summary' => 'Versions 1..n; once bad, all later are bad. Search [1, n]. If mid is bad, the first bad is in [l, mid]; else [mid+1, r]. Return l. Use unsigned or l+(r−l)/2 so n near 2³¹−1 does not overflow. Do not scan linearly.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'kind' => 'algo',
    'tags' => ['binary-search', 'interactive', 'leetcode'],
    'related_session' => 'first-bad-version',
];

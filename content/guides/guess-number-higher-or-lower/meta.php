<?php
declare(strict_types=1);

return [
    'title' => 'Guess Number Higher or Lower: binary search with guess API',
    'leetcode' => 374,
    'summary' => 'Pick is hidden in 1..n. guess(mid) is −1 if mid is too high, 1 if too low, 0 if exact. Lower-bound: first x with guess(x) ≤ 0. Overflow-safe mid. n = 10, pick = 6 → 6. Not 278 (isBadVersion). Not 375 (minmax DP).',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'kind' => 'algo',
    'tags' => ['binary-search', 'interactive', 'leetcode'],
    'related_session' => 'guess-number-higher-or-lower',
];

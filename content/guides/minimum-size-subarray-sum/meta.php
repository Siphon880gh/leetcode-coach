<?php
declare(strict_types=1);

return [
    'title' => 'Minimum Size Subarray Sum: grow right, shrink while sum is enough',
    'leetcode' => 209,
    'summary' => 'Positive nums. Expand r into a running sum. While the sum is at least target, record r−l+1 and drop nums[l]. Return the shortest length, or 0.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'kind' => 'algo',
    'tags' => ['sliding-window', 'prefix-sum', 'binary-search', 'leetcode'],
    'related_session' => 'minimum-size-subarray-sum',
];

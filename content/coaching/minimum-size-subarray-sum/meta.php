<?php
declare(strict_types=1);

return [
    'title' => 'Minimum Size Subarray Sum: grow right, shrink while sum is enough',
    'leetcode' => 209,
    'summary' => 'Walk a deterministic path: expand r into a running sum. While the sum is at least target, record the length and drop nums[l]. Return the shortest length, or 0. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'tags' => ['sliding-window', 'prefix-sum', 'binary-search', 'step-by-step'],
    'related_guide' => 'minimum-size-subarray-sum',
];

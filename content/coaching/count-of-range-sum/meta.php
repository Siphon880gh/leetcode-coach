<?php
declare(strict_types=1);

return [
    'title' => 'Count of Range Sum: prefix Fenwick on compressed values',
    'leetcode' => 327,
    'summary' => 'Walk a deterministic path: count subarrays whose sum sits in [lower, upper]. Prefix s; for each later s[j] count earlier s[i] in [s[j]−upper, s[j]−lower]. n up to 1e5 so Fenwick (or merge sort) on discretized prefixes, 64-bit sums. Not O(n²), not 303 queries, not 560 equals-k. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Indexed Tree',
    'topic' => 'LeetCode · Binary Indexed Tree',
    'tags' => ['binary-indexed-tree', 'prefix-sum', 'divide-and-conquer', 'merge-sort', 'step-by-step'],
    'related_guide' => 'count-of-range-sum',
];

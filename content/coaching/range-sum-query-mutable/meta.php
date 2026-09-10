<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query - Mutable: Fenwick prefix, delta on update',
    'leetcode' => 307,
    'summary' => 'Walk a deterministic path: values change, so a 303 prefix array is too slow. Fenwick (or a segment tree): 1-indexed prefix sums. update adds a delta; sumRange(left, right) is prefix(right+1) minus prefix(left). Both O(log n). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Indexed Tree',
    'topic' => 'LeetCode · Binary Indexed Tree',
    'tags' => ['fenwick', 'segment-tree', 'design', 'step-by-step'],
    'related_guide' => 'range-sum-query-mutable',
];

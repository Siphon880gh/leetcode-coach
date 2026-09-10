<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query - Mutable: Fenwick prefix, delta on update',
    'leetcode' => 307,
    'summary' => 'Values change, so a 303 prefix array is too slow. Fenwick (or a segment tree): 1-indexed prefix sums. update adds a delta; sumRange(left, right) is prefix(right+1) minus prefix(left). Both O(log n).',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Indexed Tree',
    'topic' => 'LeetCode · Binary Indexed Tree',
    'kind' => 'algo',
    'tags' => ['fenwick', 'segment-tree', 'design', 'leetcode'],
    'related_session' => 'range-sum-query-mutable',
];

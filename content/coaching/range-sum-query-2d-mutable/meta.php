<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query 2D - Mutable: Fenwick per row, or 2-D BIT',
    'leetcode' => 308,
    'summary' => 'Walk a deterministic path: cells change, so a 304 prefix is too slow. One Fenwick per row: update is a 1-D delta; a rectangle sums those row prefixes. A true 2-D BIT is log m times log n. Not a full scan of the box. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Indexed Tree',
    'topic' => 'LeetCode · Binary Indexed Tree',
    'tags' => ['fenwick', 'matrix', 'design', 'step-by-step'],
    'related_guide' => 'range-sum-query-2d-mutable',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Intersection of Two Arrays: unique values in both',
    'leetcode' => 349,
    'summary' => 'Walk a deterministic path: unique numbers that appear in both arrays, any order. Put nums1 in a set; walk nums2 and emit each hit once (then drop it). [1,2,2,1] and [2,2] → [2]. Not 350 (that keeps counts). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'set', 'arrays', 'step-by-step'],
    'related_guide' => 'intersection-of-two-arrays',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Intersection of Two Arrays II: keep the shared count',
    'leetcode' => 350,
    'summary' => 'Walk a deterministic path: each value appears min(count in nums1, count in nums2) times. Count nums1; walk nums2 and decrement. [1,2,2,1] and [2,2] → [2,2]. Any order. Not 349 (unique only). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'two-pointers', 'counting', 'step-by-step'],
    'related_guide' => 'intersection-of-two-arrays-ii',
];

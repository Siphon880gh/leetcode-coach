<?php
declare(strict_types=1);

return [
    'title' => 'Kth Smallest in a Sorted Matrix: binary search the value',
    'leetcode' => 378,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: n×n, rows and columns sorted. Binary search the value between the corners; count cells ≤ mid from the bottom-left. [[1,5,9],[10,11,13],[12,13,15]], k = 8 → 13. Not flatten-and-sort. Not 215. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'tags' => ['binary-search', 'matrix', 'heap', 'step-by-step'],
    'related_guide' => 'kth-smallest-element-in-a-sorted-matrix',
];

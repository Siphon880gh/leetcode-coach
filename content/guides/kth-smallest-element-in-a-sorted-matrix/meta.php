<?php
declare(strict_types=1);

return [
    'title' => 'Kth Smallest in a Sorted Matrix: binary search the value',
    'leetcode' => 378,
    'summary' => 'n×n, rows and columns sorted. kth in sorted order, not distinct. Binary search mid between the corners; count cells ≤ mid by walking from the bottom-left. [[1,5,9],[10,11,13],[12,13,15]], k = 8 → 13. Better than O(n²) extra memory. Not flatten-and-sort. Not 215.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'kind' => 'algo',
    'tags' => ['binary-search', 'matrix', 'heap', 'leetcode'],
    'related_session' => 'kth-smallest-element-in-a-sorted-matrix',
];

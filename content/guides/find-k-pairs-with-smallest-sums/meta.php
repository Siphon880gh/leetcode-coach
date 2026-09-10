<?php
declare(strict_types=1);

return [
    'title' => 'Find K Pairs with Smallest Sums: heap along sorted rows',
    'leetcode' => 373,
    'summary' => 'Two sorted arrays. Seed a min-heap with (nums1[i], nums2[0]) for the first k rows, pop the smallest, then push the next column on that row. [1,7,11] and [2,4,6], k = 3 → [[1,2],[1,4],[1,6]]. Not all pairs then sort. Not 23 (linked lists).',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'kind' => 'algo',
    'tags' => ['heap', 'arrays', 'two-pointers', 'leetcode'],
    'related_session' => 'find-k-pairs-with-smallest-sums',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Kth Largest: Quickselect at index n minus k',
    'leetcode' => 215,
    'summary' => 'Walk a deterministic path: kth in sorted order, not kth distinct. Map to index n−k in ascending order. Partition on a pivot; recurse only on the side that holds that index. Min-heap of size k is the twin. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Divide and Conquer',
    'topic' => 'LeetCode · Divide and Conquer',
    'tags' => ['quickselect', 'heap', 'sorting', 'step-by-step'],
    'related_guide' => 'kth-largest-element-in-an-array',
];

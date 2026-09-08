<?php
declare(strict_types=1);

return [
    'title' => 'Kth Largest: Quickselect at index n minus k',
    'leetcode' => 215,
    'summary' => 'kth in sorted order, not kth distinct. Map to index n−k in ascending order. Partition on a pivot; recurse only on the side that holds that index. Min-heap of size k is the twin.',
    'category' => 'LeetCode',
    'subcategory' => 'Divide and Conquer',
    'topic' => 'LeetCode · Divide and Conquer',
    'kind' => 'algo',
    'tags' => ['quickselect', 'heap', 'sorting', 'leetcode'],
    'related_session' => 'kth-largest-element-in-an-array',
];

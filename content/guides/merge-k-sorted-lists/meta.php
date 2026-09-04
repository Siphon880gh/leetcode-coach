<?php
declare(strict_types=1);

return [
    'title' => 'Merge k sorted lists: min-heap of heads',
    'leetcode' => 23,
    'summary' => 'Heap the current heads. Pop the smallest, push its next. Dummy tail builds the answer in O(n log k).',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'kind' => 'algo',
    'tags' => ['heap', 'linked-list', 'divide-and-conquer', 'leetcode'],
    'related_session' => 'merge-k-sorted-lists',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Find Median from Data Stream: max-heap left, min-heap right',
    'leetcode' => 295,
    'summary' => 'Walk a deterministic path: keep the smaller half in a max-heap and the larger half in a min-heap. Add into the max-heap, then move the top into the min-heap; rebalance if the min-heap is more than one larger. Odd: min-heap top. Even: average of both tops. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'tags' => ['heap', 'design', 'data-stream', 'step-by-step'],
    'related_guide' => 'find-median-from-data-stream',
];

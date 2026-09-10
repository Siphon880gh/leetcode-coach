<?php
declare(strict_types=1);

return [
    'title' => 'Find Median from Data Stream: max-heap left, min-heap right',
    'leetcode' => 295,
    'summary' => 'Keep the smaller half in a max-heap and the larger half in a min-heap. Add into the max-heap, then move the top into the min-heap; rebalance if the min-heap is more than one larger. Odd: min-heap top. Even: average of both tops.',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'kind' => 'algo',
    'tags' => ['heap', 'design', 'data-stream', 'leetcode'],
    'related_session' => 'find-median-from-data-stream',
];

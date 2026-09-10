<?php
declare(strict_types=1);

return [
    'title' => 'Moving Average from Data Stream: running sum of a fixed window',
    'leetcode' => 346,
    'summary' => 'Window size size. next(val) is the mean of the last min(count, size) values. Keep a running sum; drop the outgoing value when the window is full. Size 3: 1 → 1.0, then 10 → 5.5, then 3 → 4.666…, then 5 → 6.0. O(1) per next.',
    'category' => 'LeetCode',
    'subcategory' => 'Queue',
    'topic' => 'LeetCode · Queue',
    'kind' => 'algo',
    'tags' => ['queue', 'design', 'sliding-window', 'leetcode'],
    'related_session' => 'moving-average-from-data-stream',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Moving Average from Data Stream: running sum of a fixed window',
    'leetcode' => 346,
    'summary' => 'Walk a deterministic path: keep a running sum of at most size values. When the window is full, drop the outgoing slot before adding val. Divide by the current count, not always size. Size 3: 1 → 1.0, then 10 → 5.5, then 3 → 4.666…, then 5 → 6.0. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Queue',
    'topic' => 'LeetCode · Queue',
    'tags' => ['queue', 'design', 'sliding-window', 'step-by-step'],
    'related_guide' => 'moving-average-from-data-stream',
];

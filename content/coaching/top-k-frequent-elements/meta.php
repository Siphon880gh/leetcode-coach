<?php
declare(strict_types=1);

return [
    'title' => 'Top K Frequent Elements: count, then a min-heap of size k',
    'leetcode' => 347,
    'summary' => 'Walk a deterministic path: count with a map, then a min-heap of size k on frequency (evict the rarest). Bucket lists by count, then walk from n down, is O(n). [1,1,1,2,2,3], k=2 → [1,2]. Not 215 (kth largest). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'tags' => ['heap', 'hash-table', 'bucket-sort', 'step-by-step'],
    'related_guide' => 'top-k-frequent-elements',
];

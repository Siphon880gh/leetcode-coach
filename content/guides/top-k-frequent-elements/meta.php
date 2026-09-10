<?php
declare(strict_types=1);

return [
    'title' => 'Top K Frequent Elements: count, then a min-heap of size k',
    'leetcode' => 347,
    'summary' => 'k most frequent values, any order; the set is unique. Count with a map. Keep a min-heap of size k on frequency (evict the rarest). Bucket lists by count, then walk from n down, is O(n). [1,1,1,2,2,3], k=2 → [1,2]. Not 215 (kth largest).',
    'category' => 'LeetCode',
    'subcategory' => 'Heap',
    'topic' => 'LeetCode · Heap',
    'kind' => 'algo',
    'tags' => ['heap', 'hash-table', 'bucket-sort', 'leetcode'],
    'related_session' => 'top-k-frequent-elements',
];

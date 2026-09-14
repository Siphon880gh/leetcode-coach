<?php
declare(strict_types=1);

return [
    'title' => 'All O(1) Data Structure: count buckets in a doubly linked list',
    'leetcode' => 432,
    'difficulty' => 'Hard',
    'summary' => 'inc, dec, getMaxKey, getMinKey each in constant time. Map key → bucket. Buckets are a circular DLL ordered by count; each bucket holds the set of keys at that count. Move a key to the neighbor bucket (create if the next count is missing). Dummy.next is min, dummy.prev is max. Empty → "". Not LFU (460).',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-table', 'linked-list', 'leetcode'],
];

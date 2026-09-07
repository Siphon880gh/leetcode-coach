<?php
declare(strict_types=1);

return [
    'title' => 'LRU Cache: map plus a doubly linked list',
    'leetcode' => 146,
    'summary' => 'Hash key to node. Dummy head/tail DLL: move accessed nodes to the head; evict tail.prev. Store key on the node. O(1) get and put.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'linked-list', 'design', 'leetcode'],
    'related_session' => 'lru-cache',
];

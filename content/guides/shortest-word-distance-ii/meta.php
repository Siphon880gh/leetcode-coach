<?php
declare(strict_types=1);

return [
    'title' => 'Shortest Word Distance II: index lists, two pointers',
    'leetcode' => 244,
    'summary' => 'Many shortest queries on a fixed dict. Map each word to its increasing index list. On a query, two-pointer walk the two lists and advance the smaller index. O(n) build, O(p + q) per call.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'two-pointers', 'design', 'leetcode'],
    'related_session' => 'shortest-word-distance-ii',
];

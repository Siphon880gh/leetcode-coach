<?php
declare(strict_types=1);

return [
    'title' => 'Shortest Word Distance II: index lists, two pointers',
    'leetcode' => 244,
    'summary' => 'Walk a deterministic path: map each word to its increasing indices once, then two-pointer merge the two lists per query. Rescanning the dict every call is too slow. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'two-pointers', 'design', 'step-by-step'],
    'related_guide' => 'shortest-word-distance-ii',
];

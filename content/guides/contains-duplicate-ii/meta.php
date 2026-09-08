<?php
declare(strict_types=1);

return [
    'title' => 'Contains Duplicate II: last index within k',
    'leetcode' => 219,
    'summary' => 'True if the same value appears at two indices at most k apart. Map each value to its last index. On a hit, check i minus last ≤ k, then always store the new index.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Map',
    'topic' => 'LeetCode · Hash Map',
    'kind' => 'algo',
    'tags' => ['hash-map', 'sliding-window', 'arrays', 'leetcode'],
    'related_session' => 'contains-duplicate-ii',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Contains Duplicate II: last index within k',
    'leetcode' => 219,
    'summary' => 'Walk a deterministic path: true if the same value appears at two indices at most k apart. Map each value to its last index. On a hit, check i minus last ≤ k, then always store the new index. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Map',
    'topic' => 'LeetCode · Hash Map',
    'tags' => ['hash-map', 'sliding-window', 'arrays', 'step-by-step'],
    'related_guide' => 'contains-duplicate-ii',
];

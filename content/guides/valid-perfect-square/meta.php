<?php
declare(strict_types=1);

return [
    'title' => 'Valid Perfect Square: binary search for an exact square',
    'leetcode' => 367,
    'summary' => 'True iff num is k × k for an integer k. Binary search the smallest x with x × x ≥ num, then check equality. 16 true; 14 false. Compare with divide or a 64-bit product so a 32-bit multiply cannot wrap. Not floor sqrt (69). Not a language sqrt.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'kind' => 'algo',
    'tags' => ['binary-search', 'math', 'leetcode'],
    'related_session' => 'valid-perfect-square',
];

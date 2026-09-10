<?php
declare(strict_types=1);

return [
    'title' => 'Valid Perfect Square: binary search for an exact square',
    'leetcode' => 367,
    'summary' => 'Walk a deterministic path: true iff num is k × k. Binary search the smallest x with x × x ≥ num, then check equality. 16 true; 14 false. 64-bit product or divide so 32-bit multiply cannot wrap. Not floor sqrt (69). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'tags' => ['binary-search', 'math', 'step-by-step'],
    'related_guide' => 'valid-perfect-square',
];

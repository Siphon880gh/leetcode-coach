<?php
declare(strict_types=1);

return [
    'title' => 'Move Zeroes: write pointer packs non-zeros',
    'leetcode' => 283,
    'summary' => 'Walk a deterministic path: keep non-zero order. k is the next write slot. Scan i; when nums[i] is not 0, swap with nums[k] and bump k. In place. Not a sort, not a second array. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'tags' => ['arrays', 'two-pointers', 'in-place', 'step-by-step'],
    'related_guide' => 'move-zeroes',
];

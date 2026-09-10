<?php
declare(strict_types=1);

return [
    'title' => 'Move Zeroes: write pointer packs non-zeros',
    'leetcode' => 283,
    'summary' => 'Keep non-zero order. k is the next write slot. Scan i; when nums[i] is not 0, swap with nums[k] and bump k. Zeros land at the end. In place.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'two-pointers', 'in-place', 'leetcode'],
    'related_session' => 'move-zeroes',
];

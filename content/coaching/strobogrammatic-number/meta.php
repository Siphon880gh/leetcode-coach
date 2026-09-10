<?php
declare(strict_types=1);

return [
    'title' => 'Strobogrammatic Number: rotate 180, pair from both ends',
    'leetcode' => 246,
    'summary' => 'Walk a deterministic path: map 0,1,8 to themselves and 6↔9; reject 2,3,4,5,7. Two pointers: rotate of the left digit must equal the right. Odd middle must map to itself. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'tags' => ['two-pointers', 'strings', 'hash-table', 'step-by-step'],
    'related_guide' => 'strobogrammatic-number',
];

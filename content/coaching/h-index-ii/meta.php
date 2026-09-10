<?php
declare(strict_types=1);

return [
    'title' => 'H-Index II: binary search h on a non-decreasing citations array',
    'leetcode' => 275,
    'summary' => 'Walk a deterministic path: same h as 274, but the array is already sorted ascending. Search h in 0..n. citations[n − h] ≥ h means the last h papers each have at least h cites. Do not sort again. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Binary Search',
    'topic' => 'LeetCode · Binary Search',
    'tags' => ['binary-search', 'arrays', 'step-by-step'],
    'related_guide' => 'h-index-ii',
];

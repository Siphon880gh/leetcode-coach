<?php
declare(strict_types=1);

return [
    'title' => 'Arithmetic Slices: count endings of a constant-diff run',
    'leetcode' => 413,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: count contiguous arithmetic subarrays of length at least 3. If the adjacent difference stays the same, the run of extra triples grows by 1 and add that to the answer. [1,2,3,4] → 3. [1] → 0. Not 446. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'arrays', 'sliding-window', 'step-by-step'],
    'related_guide' => 'arithmetic-slices',
];

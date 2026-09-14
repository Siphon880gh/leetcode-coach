<?php
declare(strict_types=1);

return [
    'title' => 'Arithmetic Slices: count endings of a constant-diff run',
    'leetcode' => 413,
    'difficulty' => 'Med',
    'summary' => 'Count contiguous arithmetic subarrays of length at least 3. Walk adjacent pairs; if the difference stays the same, the run of extra triples grows by 1 and add that to the answer. [1,2,3,4] → 3. [1] → 0. Not 446 (subsequences).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'arrays', 'sliding-window', 'leetcode'],
    'related_session' => 'arithmetic-slices',
];

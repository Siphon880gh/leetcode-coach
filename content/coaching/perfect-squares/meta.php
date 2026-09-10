<?php
declare(strict_types=1);

return [
    'title' => 'Perfect Squares: unbounded knapsack with square coins',
    'leetcode' => 279,
    'summary' => 'Walk a deterministic path: least squares that sum to n. Squares are coins you may reuse. f[j] = min(f[j], f[j − i²] + 1). 12 is three 4s, not greedy 9+1+1+1. Not Add Digits. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'knapsack', 'math', 'step-by-step'],
    'related_guide' => 'perfect-squares',
];

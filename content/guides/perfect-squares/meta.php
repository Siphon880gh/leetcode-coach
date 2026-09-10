<?php
declare(strict_types=1);

return [
    'title' => 'Perfect Squares: unbounded knapsack with square coins',
    'leetcode' => 279,
    'summary' => 'Least number of squares that sum to n. Squares are coins you may reuse. f[0]=0; for each i², relax f[j] = min(f[j], f[j − i²] + 1). 12 is three 4s, not greedy 9+1+1+1. Not Add Digits.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'knapsack', 'math', 'leetcode'],
    'related_session' => 'perfect-squares',
];

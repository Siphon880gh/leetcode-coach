<?php
declare(strict_types=1);

return [
    'title' => 'Combination Sum IV: order matters, DP on the target',
    'leetcode' => 377,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: count sequences (not sets) that sum to target. f[0]=1; for each sum i, add f[i−x] for every x. [1,2,3] and 4 → 7 because (1,3) and (3,1) both count. Loop the target outside the coins. Not 39. Not 322. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'knapsack', 'permutations', 'step-by-step'],
    'related_guide' => 'combination-sum-iv',
];

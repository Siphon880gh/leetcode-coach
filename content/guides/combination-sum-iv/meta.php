<?php
declare(strict_types=1);

return [
    'title' => 'Combination Sum IV: order matters, DP on the target',
    'leetcode' => 377,
    'summary' => 'Count sequences (not sets) of distinct nums that sum to target. f[0]=1; for each sum i, add f[i−x] for every x. [1,2,3] and 4 → 7 because (1,3) and (3,1) both count. Loop the target outside the coins. Not 39 (sets). Not 322 (fewest coins).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'knapsack', 'permutations', 'leetcode'],
    'related_session' => 'combination-sum-iv',
];

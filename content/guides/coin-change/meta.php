<?php
declare(strict_types=1);

return [
    'title' => 'Coin Change: unbounded knapsack, fewest coins',
    'leetcode' => 322,
    'summary' => 'Fewest coins to make amount; infinite supply of each denomination. f[0]=0; for each coin x, walk j from x to amount and set f[j] = min(f[j], f[j − x] + 1). Impossible → −1. [1,2,5] and 11 → 3. Greedy fails.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'knapsack', 'unbounded-knapsack', 'leetcode'],
    'related_session' => 'coin-change',
];

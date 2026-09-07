<?php
declare(strict_types=1);

return [
    'title' => 'Best Time to Buy and Sell Stock IV: at most k trades',
    'leetcode' => 188,
    'summary' => 'Generalize Stock III from two trades to k. For each trade count j: cash vs holding. Buy from j-1 cash; sell from same j holding. Return cash after k buys. If k is huge, same as Stock II.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'stock', 'state-machine', 'leetcode'],
];

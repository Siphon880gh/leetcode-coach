<?php
declare(strict_types=1);

return [
    'title' => 'House Robber II: max of skip-first and skip-last',
    'leetcode' => 213,
    'summary' => 'Walk a deterministic path: houses sit in a circle, so index 0 and n−1 are adjacent. Run the linear House Robber on [0 .. n−2] and on [1 .. n−1]; take the larger. One house is that house. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'arrays', 'step-by-step'],
    'related_guide' => 'house-robber-ii',
];

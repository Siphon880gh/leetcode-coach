<?php
declare(strict_types=1);

return [
    'title' => 'Guess Number Higher or Lower II: minmax interval DP',
    'leetcode' => 375,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: pay the guessed x on every miss. Need the min cash that still wins against the worst pick. f[i][j] = min over k of k plus the worse leftover interval. n = 10 → 16. Not 374. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'minimax', 'game-theory', 'step-by-step'],
    'related_guide' => 'guess-number-higher-or-lower-ii',
];

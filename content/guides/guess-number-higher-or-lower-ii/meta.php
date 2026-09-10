<?php
declare(strict_types=1);

return [
    'title' => 'Guess Number Higher or Lower II: minmax interval DP',
    'leetcode' => 375,
    'summary' => 'Pay the guessed x on every miss. Need the min cash that still wins against the worst pick. f[i][j] = min over k of k plus the worse of [i, k−1] and [k+1, j]. n = 10 → 16. Not 374 (find the pick). Not binary search for the number.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'minimax', 'game-theory', 'leetcode'],
    'related_session' => 'guess-number-higher-or-lower-ii',
];

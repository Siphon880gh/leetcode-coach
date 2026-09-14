<?php
declare(strict_types=1);

return [
    'title' => 'Frog Jump: last step k, next is k−1 / k / k+1',
    'leetcode' => 403,
    'difficulty' => 'Hard',
    'summary' => 'Stones in increasing units. Start at the first stone; the first jump must be 1. From last jump k, the next is k−1, k, or k+1 (forward only) and must land on a stone. Memo dfs(i, k). [0,1,3,5,6,8,12,17] true. [0,1,2,3,4,8,9,11] false. Not Jump Game (55).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'memoization', 'hash-table', 'leetcode'],
    'related_session' => 'frog-jump',
];

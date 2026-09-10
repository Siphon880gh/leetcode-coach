<?php
declare(strict_types=1);

return [
    'title' => 'Longest Increasing Path in a Matrix: memo DFS on a DAG',
    'leetcode' => 329,
    'summary' => 'Longest 4-direction path of strictly increasing cells. No diagonal, no wrap. dfs(i, j) is 1 plus the best larger neighbor; cache it. Strict increase makes a DAG so memo is enough. [[9,9,4],[6,6,8],[2,1,1]] → 4. Not 300 LIS.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'depth-first-search', 'memoization', 'matrix', 'leetcode'],
    'related_session' => 'longest-increasing-path-in-a-matrix',
];

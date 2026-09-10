<?php
declare(strict_types=1);

return [
    'title' => 'Longest Increasing Path in a Matrix: memo DFS on a DAG',
    'leetcode' => 329,
    'summary' => 'Walk a deterministic path: longest 4-direction path of strictly increasing cells. No diagonal, no wrap. dfs(i, j) is 1 plus the best larger neighbor; cache it. Strict increase makes a DAG so memo is enough. [[9,9,4],[6,6,8],[2,1,1]] → 4. Not 300 LIS. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'depth-first-search', 'memoization', 'matrix', 'step-by-step'],
    'related_guide' => 'longest-increasing-path-in-a-matrix',
];

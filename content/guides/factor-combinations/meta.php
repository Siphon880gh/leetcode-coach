<?php
declare(strict_types=1);

return [
    'title' => 'Factor Combinations: DFS from 2, keep factors non-decreasing, never emit [n]',
    'leetcode' => 254,
    'summary' => 'Split n into factors in [2, n−1]. dfs(remain, start) records the path plus remain when the path is already non-empty. Try divisors from start through sqrt(remain) so lists stay sorted and duplicates stay out.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'dfs', 'math', 'leetcode'],
    'related_session' => 'factor-combinations',
];

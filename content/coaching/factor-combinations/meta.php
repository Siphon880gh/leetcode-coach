<?php
declare(strict_types=1);

return [
    'title' => 'Factor Combinations: DFS from 2, keep factors non-decreasing, never emit [n]',
    'leetcode' => 254,
    'summary' => 'Walk a deterministic path: dfs(remain, start) records path plus remain when the path is non-empty. Try divisors from start through sqrt(remain) so lists stay sorted. Never emit [n]. 1 and primes are empty. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'dfs', 'math', 'step-by-step'],
    'related_guide' => 'factor-combinations',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Strobogrammatic Number II: wrap rotate pairs around a shorter core',
    'leetcode' => 247,
    'summary' => 'Walk a deterministic path: dfs(u) from dfs(u−2). Wrap 1/1, 8/8, 6/9, 9/6. Wrap 0 only when u is not the finished n. Middle of odd length is 0, 1, or 8. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Recursion',
    'topic' => 'LeetCode · Recursion',
    'tags' => ['recursion', 'strings', 'backtracking', 'step-by-step'],
    'related_guide' => 'strobogrammatic-number-ii',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Combination sum II: skip twins at this depth',
    'leetcode' => 40,
    'summary' => 'Each index once: recurse on j+1. After sorting, skip candidates[j] == candidates[j-1] when j > i.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'arrays', 'dfs', 'leetcode'],
    'related_session' => 'combination-sum-ii',
];

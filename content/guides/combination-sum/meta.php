<?php
declare(strict_types=1);

return [
    'title' => 'Combination sum: reuse the same index',
    'leetcode' => 39,
    'summary' => 'DFS from index i. Recurse on j (not j+1) so a candidate can be picked again. Sort to prune when remain is too small.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'arrays', 'dfs', 'leetcode'],
    'related_session' => 'combination-sum',
];

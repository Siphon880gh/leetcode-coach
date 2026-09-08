<?php
declare(strict_types=1);

return [
    'title' => 'Combination Sum III: k distinct digits from 1 to 9',
    'leetcode' => 216,
    'summary' => 'Walk a deterministic path: exactly k numbers from 1 through 9, each at most once, summing to n. DFS take-or-skip the next digit; prune when the digit, remaining sum, or length cannot work. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'dfs', 'combinations', 'step-by-step'],
    'related_guide' => 'combination-sum-iii',
];

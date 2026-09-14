<?php
declare(strict_types=1);

return [
    'title' => 'Lexicographical Numbers: ten-ary DFS without sorting strings',
    'leetcode' => 386,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: return 1..n in dictionary order. n=13 → [1,10,11,12,13,2,…,9]. Start at 1; if 10×v ≤ n go deeper; else while v ends in 9 or v+1 > n, drop the last digit, then add 1. O(1) extra. Do not stringify and sort. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Depth-First Search',
    'topic' => 'LeetCode · Depth-First Search',
    'tags' => ['dfs', 'trie', 'math', 'step-by-step'],
    'related_guide' => 'lexicographical-numbers',
];

<?php
declare(strict_types=1);

return [
    'title' => 'Lexicographical Numbers: ten-ary DFS without sorting strings',
    'leetcode' => 386,
    'summary' => 'Return 1..n in dictionary order. n=13 → [1,10,11,12,13,2,…,9]. Walk like a digit trie: start at 1; if 10×v ≤ n go deeper (append a 0); else while v ends in 9 or v+1 > n, drop the last digit, then add 1. n numbers, O(1) extra. Do not stringify and sort.',
    'category' => 'LeetCode',
    'subcategory' => 'Depth-First Search',
    'topic' => 'LeetCode · Depth-First Search',
    'kind' => 'algo',
    'tags' => ['dfs', 'trie', 'math', 'leetcode'],
];
